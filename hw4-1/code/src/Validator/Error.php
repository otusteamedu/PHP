<?php
declare(strict_types=1);

namespace App\Validator;

/**
 * Class Error
 */
final class Error
{
    /**
     * @param string $message
     */
    public function __construct(
        public string $message,
    ) {
    }
}
