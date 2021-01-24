<?php


namespace Otushw\Exception;

use Monolog\Logger;

class MapperException extends AppException
{

    /**
     * @param string $message
     */
    protected function addTologException(string $message): void
    {
        $this->log->addTolog(Logger::ERROR, $message);
    }
}