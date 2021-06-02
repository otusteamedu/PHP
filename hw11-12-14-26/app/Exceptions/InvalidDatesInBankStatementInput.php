<?php
declare(strict_types=1);

namespace App\Exceptions;

use Throwable;
use JetBrains\PhpStorm\Pure;
use InvalidArgumentException;

class InvalidDatesInBankStatementInput extends InvalidArgumentException
{
    /**
     * InvalidDatesInBankStatementInput constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    #[Pure]
    public function __construct($message = "Invalid dates in bank statement input data!", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
