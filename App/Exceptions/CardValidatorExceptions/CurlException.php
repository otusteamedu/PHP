<?php

namespace Exception\CardValidatorExceptions;

use Throwable;

class CurlException extends \Exception
{

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function __toString() {
        $result = sprintf(
            "%s: %s\n",
            __CLASS__,
            $this->message
        );
        return $result;
    }
}