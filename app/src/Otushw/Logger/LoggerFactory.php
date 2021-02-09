<?php


namespace Otushw\Logger;

use Monolog\Handler\HandlerInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Exception;

class LoggerFactory
{
    private static $instance = null;

    /**
     * LoggerFactory constructor.
     *
     * @throws Exception
     */
    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (self::$instance != null) {
            return self::$instance;
        }
        $log = new Logger($_ENV['log']['name_channel']);
        $log->pushHandler(self::getHandler($_ENV['log']['type']));

        self::$instance = $log;
        return self::$instance;
    }

    /**
     * @param string $type
     *
     * @return HandlerInterface
     * @throws Exception
     */
    private function getHandler(string $type): HandlerInterface
    {
        switch ($type) {
            case 'file':
                $file = self::getFilePath();
                $handler = new StreamHandler($file);
                break;
        }

        return $handler;
    }

    /**
     * @return string
     * @throws Exception
     */
    private function getFilePath(): string
    {
        $nameSettings = $_ENV['log']['type'] . '_settings';
        if (empty($_ENV['log'][$nameSettings])) {
            throw new Exception('Check config.yaml, it has not "file_section"');
        }
        return $_ENV['log'][$nameSettings]['file_path'];
    }
}
