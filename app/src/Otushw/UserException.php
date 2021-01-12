<?php


namespace Otushw;

use Monolog\Logger;

class UserException extends AppException
{

    public function log(string $msg)
    {
        $this->log->addRecord(Logger::NOTICE, $msg);
    }
}
