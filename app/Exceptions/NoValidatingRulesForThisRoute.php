<?php

namespace App\Exceptions;

use Exception;

class NoValidatingRulesForThisRoute extends Exception
{
    /**
     * NoValidatingRulesForThisRoute constructor.
     *
     * @param string $message
     */
    public function __construct($message = "There is no validating rule for this route!")
    {
        parent::__construct($message);
    }
}
