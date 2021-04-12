<?php

namespace App\Log;

use App\Config\Config;
use App\Singleton\Singleton;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class Log extends Singleton
{
    private Logger $logger;

    protected function __construct ()
    {
        $logger = new Logger('app');
        $logger->pushHandler(new StreamHandler(Config::getInstance()->getItem('log_path')));

        $this->logger = $logger;
    }

    public function addRecord (string $message, int $level = Logger::INFO): void
    {
        $this->logger->addRecord($level, $message);
    }
}
