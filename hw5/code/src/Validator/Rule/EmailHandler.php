<?php
declare(strict_types=1);

namespace App\Validator\Rule;

use App\Validator\Error;
use App\Validator\RuleHandlerInterface;
use App\Validator\RuleInterface;

/**
 * Class EmailHandler
 */
final class EmailHandler implements RuleHandlerInterface
{
    /**
     * {@inheritDoc}
     */
    public static function getRule(): string
    {
        return Email::class;
    }

    /**
     * {@inheritDoc}
     */
    public function handle(mixed $value, RuleInterface $rule): \Generator
    {
        if ($value === null) {
            return;
        }

        $regexp = '~^[\p{L}\d](?!.*[.\-_+]{2})[\p{L}\d.\-_+]*[\p{L}\d]@[\p{L}\d-]+(?:\.[\p{L}\d-]{2,})+$~u';

        if (!preg_match($regexp, $value)) {
            yield new Error($rule->message);

            return;
        }

        $host = mb_substr($value, mb_strrpos($value, '@') + 1);

        if ($host !== '' && (checkdnsrr($host) || checkdnsrr($host, 'A') || checkdnsrr($host, 'AAAA'))) {
            return;
        }

        yield new Error($rule->message);
    }
}
