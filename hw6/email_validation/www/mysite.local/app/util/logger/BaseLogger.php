<?php

namespace App\Util\Logger;

class BaseLogger implements LoggerInterface
{
    public function info(string $message): void
    {
        echo sprintf('[INFO]: %s<br />', $message);
    }

    public function error(string $message): void
    {
        echo sprintf('[ERROR]: %s<br />', $message);
    }

    public function exception(\Throwable $t): void
    {
        echo sprintf('[CRITICAL]: %s<br />', $t->getMessage());
        echo sprintf('[CRITICAL]: %s<br />', $t->getTraceAsString());
    }

    public function newLine(): void
    {
        echo '<br />';
    }
}