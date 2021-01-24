<?php


namespace Otushw\Exception;

use Monolog\Logger;

/**
 * Class MapperException
 *
 * @package Otushw\Exception
 */
class MapperException extends AppException
{

    /**
     * @param string $message
     */
    protected function addTologException(string $message): void
    {
        $this->log->addTolog(Logger::ERROR, 'Mapper: '. $message);
    }
}