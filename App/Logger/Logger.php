<?php 

namespace Logger;

use Logger\Contracts\LoggerInterface;
use Exception;

class Logger implements LoggerInterface
{
    private $filename;
    private $log;
    private static $logPath = __DIR__ . '/logFiles/';

    public function __construct(string $filename,string $log)
    {
        $this->file = $filename;
        $this->log = $log;
    }

    /**
     * Функция логирования в файл
     * @throws Exception
     * @param string $filename
     * @param string $log
     */
    public static function logToFile(string $filename,string $log)
    {
        try {
            if(!file_put_contents(self::$logPath . $filename, $log . PHP_EOL, FILE_APPEND | LOCK_EX)) {
                throw new Exception('Ошибка записи лога');
            }
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }
}