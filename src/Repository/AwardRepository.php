<?php

namespace App\Repository;

use App\Entity\Award;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;

/**
 * @method Award|null find($id, $lockMode = null, $lockVersion = null)
 * @method Award|null findOneBy(array $criteria, array $orderBy = null)
 * @method Award[]    findAll()
 * @method Award[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AwardRepository extends ServiceEntityRepository
{
    private $logger;

    public function __construct(ManagerRegistry $registry, LoggerInterface $logger)
    {
        parent::__construct($registry, Award::class);
        $this->logger = $logger;
    }

    public function insertFromCsv(array $record): array
    {
        $entityManager = $this->getEntityManager();

        $award = new Award();
        $award->setTitle($record['award']);
        $award->setStock(intval($record['stock']));
        $award->setCreated(new \DateTimeImmutable("now"));
        $award->setUpdated(new \DateTimeImmutable("now"));

        $entityManager->persist($award);
        $entityManager->flush();

        return array($award->getId(), $award->getStock());
    }
}
