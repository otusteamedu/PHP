<?php

namespace Exception\CardValidatorExceptions;

use Throwable;

class CardValidatorException extends \Exception
{

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function __toString() {
        $result = sprintf(
            "%s: [%i]: %s\n",
            __CLASS__,
            $this->code,
            $this->message
        );
        return $result;
    }
}