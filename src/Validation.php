<?php

namespace HW7_1;

use Psr\Log\LoggerInterface;

/**
 * Interface Validation
 * @package HW7_1
 */
interface Validation
{
    public function validate(string $email): bool;

    public function setLogger(LoggerInterface $logger): void;
}
