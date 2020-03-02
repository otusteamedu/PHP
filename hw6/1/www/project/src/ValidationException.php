<?php


namespace App;

use Throwable;

/**
 * Class ValidationException
 * @package App
 */
class ValidationException extends \Exception
{
    const EXCEPTION_RULES = 'no rules added';
    const EXCEPTION_DATA = 'no data added';
    const EXCEPTION_RULES_NOT_FOUNT = '- no rule found';

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
