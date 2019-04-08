<?php

namespace HW7_1;

use Psr\Log\LoggerInterface;

abstract class AbstractBaseValidation implements Validation
{
    /** @var LoggerInterface */
    private $logger;

    abstract public function validate(string $email): bool;

    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }

    protected function debug(string $message, array $context = []): void
    {
        $this->logger && $this->logger->debug($message, $context);
    }

    protected function error(string $message, array $context = []): void
    {
        $this->logger && $this->logger->error($message, $context);
    }
}
