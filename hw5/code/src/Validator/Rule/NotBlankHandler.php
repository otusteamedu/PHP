<?php
declare(strict_types=1);

namespace App\Validator\Rule;

use App\Validator\Error;
use App\Validator\RuleHandlerInterface;
use App\Validator\RuleInterface;

/**
 * Class NotBlankHandler
 */
final class NotBlankHandler implements RuleHandlerInterface
{
    /**
     * {@inheritDoc}
     */
    public static function getRule(): string
    {
        return NotBlank::class;
    }

    /**
     * {@inheritDoc}
     */
    public function handle(mixed $value, RuleInterface $rule): \Generator
    {
        if (empty($value) && '0' !== $value) {
            yield new Error($rule->message);
        }
    }
}
