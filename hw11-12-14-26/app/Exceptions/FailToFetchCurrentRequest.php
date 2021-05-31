<?php
declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;
use JetBrains\PhpStorm\Pure;

class FailToFetchCurrentRequest extends Exception
{
    /**
     * FailToFetchCurrentRequest constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    #[Pure]
    public function __construct($message = "Fail to fetch current request!", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
