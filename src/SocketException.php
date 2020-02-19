<?php

namespace App;

use Exception;
use Throwable;

class SocketException extends Exception
{
    public function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        if ($errorcode = socket_last_error()) {
            $code = $errorcode;
            if ($errormsg = socket_strerror($errorcode)) {
                $message .= "\n$errormsg\n";
            }
        }
        parent::__construct($message, $code, $previous);
    }
}
