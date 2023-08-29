<?php

declare(strict_types=1);

namespace App\UseCase;

use App\Exception\ServiceIsNotEvailable;
use Predis\Client;
use Psr\Log\LoggerInterface;

class GetReportUseCase
{
    public function __construct (
        private Client $redis,
        private LoggerInterface $logger,
    ){}

    public function execute(): array
    {
        try {
            return $this->redis->hgetall('countryHash');
        } catch (\Throwable $exception) {
            $this->logger->critical($exception->getMessage());
            throw new ServiceIsNotEvailable();
        }
    }
}