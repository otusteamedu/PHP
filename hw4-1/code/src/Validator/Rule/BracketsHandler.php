<?php
declare(strict_types=1);

namespace App\Validator\Rule;

use App\Validator\Error;
use App\Validator\RuleHandlerInterface;
use App\Validator\RuleInterface;

/**
 * Class BracketsHandler
 */
final class BracketsHandler implements RuleHandlerInterface
{
    /**
     * {@inheritDoc}
     */
    public static function getRule(): string
    {
        return Brackets::class;
    }

    /**
     * {@inheritDoc}
     */
    public function handle(mixed $value, RuleInterface $rule): \Generator
    {
        if (!is_string($value)) {
            throw new \InvalidArgumentException(
                sprintf('Expected argument of type string, %s passed', get_debug_type($value))
            );
        }

        do {
            $value = preg_replace('~\(\)~', '', $value, -1, $count);
        } while ($count > 0);

        if (!$value) {
            return;
        }

        yield new Error($rule->message);
    }
}
