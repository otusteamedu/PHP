<?php
declare(strict_types=1);

namespace App\Validator;

/**
 * Interface RuleHandlerInterface
 */
interface RuleHandlerInterface
{
    /**
     * Returns rule's FQCN
     *
     * @return string
     */
    public static function getRule(): string;

    /**
     * @param mixed         $value
     * @param RuleInterface $rule
     *
     * @return \Generator
     */
    public function handle(mixed $value, RuleInterface $rule): \Generator;
}
