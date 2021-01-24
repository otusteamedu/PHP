<?php


namespace Otushw\Exception;

use Monolog\Logger;

/**
 * Class UserException
 *
 * @package Otushw\Exception
 */
class UserException extends AppException
{

    /**
     * @param string $message
     */
    protected function addTologException(string $message): void
    {
        $this->log->addTolog(Logger::NOTICE, $message);
    }
}
