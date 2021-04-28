<?php
declare(strict_types=1);

namespace App\Validator;

/**
 * Class RuleHandlerNotFound
 */
final class RuleHandlerNotFoundException extends \RuntimeException
{
    /**
     * @param string          $rule
     * @param \Throwable|null $previous
     */
    public function __construct(string $rule, \Throwable $previous = null)
    {
        parent::__construct(
            sprintf('No handler found for rule "%s"', $rule),
            0,
            $previous
        );
    }
}
