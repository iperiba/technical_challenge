<?php

namespace App\Service\handlers;

use App\Repository\CodeRepository;
use League\Csv\Writer;
use Psr\Log\LoggerInterface;

class RandomCodeHandler
{
    const ALPHANUMERIC = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

    private $logger;
    private $codeRepository;
    private $locationNewCsv;
    private $numberRandomCodes;
    private $codeDatabase;

    public function __construct(LoggerInterface $logger, CodeRepository $codeRepository, string $locationNewCsv, int $numberRandomCodes, string $codeDatabase)
    {
        $this->logger = $logger;
        $this->codeRepository = $codeRepository;
        $this->locationNewCsv = $locationNewCsv;
        $this->numberRandomCodes = $numberRandomCodes;
        $this->codeDatabase = $codeDatabase;
    }

    public function insertRandomCodeDatabase(array $generatedCsv)
    {
        foreach ($generatedCsv as $csv) {
            $this->codeRepository->insertRandomCode($this->locationNewCsv.$csv, $this->codeDatabase);
        }
    }

    public function generateRandomCodeCsv(array $awardsArray): array
    {
        $arrayGeneratedCSV = array();

        ini_set('memory_limit', '-1');

        foreach ($awardsArray as $award) {
                $header = ['id', 'award_id', 'awarded', 'created', 'updated'];
                $records = $this->generateArrayData($award[0], $award[1]);
                $writer = Writer::createFromPath($this->locationNewCsv . $award[0] . '_file.csv', 'w');
                $writer->insertOne($header);
                $writer->insertAll($records);
                $arrayGeneratedCSV[] = $this->locationNewCsv . $award[0] . '_file.csv';
        }

        return $arrayGeneratedCSV;
    }

    public function generateArrayData($id, $stock): array
    {
        $arrayRecords = array();
        $gapAwardedCodes = $this->numberRandomCodes / $stock;

        $i = 1;
        $formerCode = "";
        while ($i <= $this->numberRandomCodes) {
            $newCode = $this->randomStrings(8);
            if($newCode !==  $formerCode) {
                $record[] = $this->randomStrings(8);
                $record[] = $id;

                if ($i % $gapAwardedCodes === 0) {
                    $record[] = 1;
                } else {
                    $record[] = 0;
                }

                $arrayRecords[] = $record;
                unset($record);
                $formerCode = $newCode;
                $i++;
            }
        }
        return $arrayRecords;
    }

    function randomStrings($length_of_string)
    {
        $str_result = RandomCodeHandler::ALPHANUMERIC;
        return substr(str_shuffle($str_result), 0, $length_of_string);
    }
}