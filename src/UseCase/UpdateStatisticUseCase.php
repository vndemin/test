<?php

declare(strict_types=1);

namespace App\UseCase;

use App\Exception\ServiceIsNotAvailable;
use Predis\Client;
use Psr\Log\LoggerInterface;

class UpdateStatisticUseCase
{
    public function __construct (
        private Client $redis,
        private LoggerInterface $logger,
    ){}

    public function execute(string $countryCode): void
    {
        try {
            $this->redis->hincrby('countryHash', strtolower($countryCode), 1);
        } catch (\Throwable $exception) {
            $this->logger->critical($exception->getMessage());
            throw new ServiceIsNotAvailable();
        }
    }
}