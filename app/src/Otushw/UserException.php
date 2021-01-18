<?php


namespace Otushw;

use Monolog\Logger;

class UserException extends AppException
{

    public function addTolog(string $message)
    {
        $this->log->log($this->log->getLevelUser(), $message);
    }
}
