<?php

namespace App\Controller;

use App\Repository\AwardRepository;
use App\Service\handlers\AwardHandler;
use App\Service\handlers\RandomCodeHandler;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CodeGeneratorController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(Request $request, AwardHandler $awardHandler, RandomCodeHandler $randomCodeHandler, LoggerInterface $logger)
    {
        $form = $this->createFormBuilder()
            ->add('save', SubmitType::class, ['label' => 'Generate codes'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $awardsArray = $awardHandler->registerAwards();
            $csvArray = $randomCodeHandler->generateRandomCodeCsv($awardsArray);
            $CodeDatabaseResponse = $randomCodeHandler->insertRandomCodeDatabase($csvArray);

            if(!empty($CodeDatabaseResponse)) {
                $message = "Succesful code generation";
            } else {
                $message = "Something went wrong. Check logs";
            }

            return $this->render('code_generator/success.html.twig', [
                'messsage' => $message,
            ]);
        }

        return $this->render('code_generator/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
