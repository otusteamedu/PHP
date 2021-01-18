<?php


namespace Otushw;

use Monolog\Handler\HandlerInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class LoggerFactory
{
    const LOG_PATH = '../log/app.log';
    const TYPE_FILE = 'file';
    const LEVEL_APP = Logger::ERROR;
    const LEVEL_USER = Logger::NOTICE;

    private Logger $log;

    public function __construct(string $type)
    {
        $this->log = new Logger('app');
        $this->log->pushHandler($this->getHandler($type));
    }

    public function log(int $level, string $msg)
    {
        $this->log->addRecord($level, $msg);
    }

    public function getLevelApp(): int
    {
        return self::LEVEL_APP;
    }

    public function getLevelUser(): int
    {
        return self::LEVEL_USER;
    }

    private function getHandler(string $type): HandlerInterface
    {
        switch ($type) {
            case self::TYPE_FILE:
                $handler = new StreamHandler(self::LOG_PATH);
                break;
        }

        return $handler;
    }


}