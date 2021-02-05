<?php

namespace App\Service\handlers;

use App\Repository\AwardRepository;
use League\Csv\Reader;
use League\Csv\Statement;
use Psr\Log\LoggerInterface;

class AwardHandler
{
    private $logger;
    private $locationCsv;
    private $nameCsv;
    private $awardRepository;

    public function __construct(LoggerInterface $logger, AwardRepository $awardRepository, string $locationCsv, string $nameCsv)
    {
        $this->logger = $logger;
        $this->awardRepository = $awardRepository;
        $this->locationCsv = $locationCsv;
        $this->nameCsv = $nameCsv;
    }

    /**
     * @return array
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function registerAwards(): array
    {
        $records = $this->obtainDataFromCsv();
        $awardsArray = array();

        foreach ($records as $record) {
            $awardsArray[] = $this->awardRepository->insertFromCsv($record);
        }

        return $awardsArray;
    }

    /**
     * @return object
     * @throws \League\Csv\Exception
     */
    public function obtainDataFromCsv(): object
    {
        $csv = Reader::createFromPath($this->locationCsv.$this->nameCsv, 'r');
        $csv->setHeaderOffset(0);

        $stmt = Statement::create()
            ->offset(0);

        return $stmt->process($csv);
    }
}