<?php

namespace App\Service;

use App\Service\handlers\AwardHandler;
use App\Service\handlers\RandomCodeHandler;
use Psr\Log\LoggerInterface;

class CodeGenerator
{
    private $logger;
    private $awardHandler;
    private $randomCodeHandler;

    public function __construct(LoggerInterface $logger, AwardHandler $awardHandler, RandomCodeHandler $randomCodeHandler)
    {
        $this->logger = $logger;
        $this->awardHandler = $awardHandler;
        $this->randomCodeHandler = $randomCodeHandler;
    }

    public function getHappyMessage(): string
    {
    }
}