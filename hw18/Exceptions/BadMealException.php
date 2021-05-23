<?php

namespace DesignPatterns\Exceptions;

use Throwable;
use JetBrains\PhpStorm\Pure;

class BadMealException extends \Exception
{
    /**
     * BadMealException constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    #[Pure]
    public function __construct($message = "This meal does not meet requirements!", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
