<?php


namespace Otushw;

use Monolog\Handler\HandlerInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\ElasticsearchHandler;
use Monolog\Logger;
use Exception;

class LoggerFactory
{
    private Logger $log;

    /**
     * LoggerFactory constructor.
     *
     * @throws Exception
     */
    public function __construct()
    {
        $this->log = new Logger($_ENV['log']['name_channel']);
        $this->log->pushHandler($this->getHandler($_ENV['log']['type']));
    }

    /**
     * @param int    $level
     * @param string $msg
     */
    public function addTolog(int $level, string $msg): void
    {
        $this->log->addRecord($level, $msg);
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
                $file = $this->getFilePath();
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