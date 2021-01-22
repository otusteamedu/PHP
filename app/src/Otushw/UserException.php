<?php


namespace Otushw;

use Monolog\Logger;

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
