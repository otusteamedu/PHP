<?php
declare(strict_types=1);

namespace App\Http\Exception;

use Throwable;

/**
 * Class HttpException
 */
class HttpException extends \RuntimeException
{
    /**
     * @param int            $statusCode
     * @param string         $message
     * @param Throwable|null $previous
     * @param int            $code
     */
    public function __construct(
        private int $statusCode,
        string $message = null,
        ?Throwable $previous = null,
        int $code = 0
    ) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
