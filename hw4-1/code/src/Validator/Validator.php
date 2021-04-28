<?php
declare(strict_types=1);

namespace App\Validator;

/**
 * Class Validator
 */
final class Validator
{
    /**
     * @param RuleHandlerRegistry $ruleHandlerRegistry
     */
    public function __construct(
        private RuleHandlerRegistry $ruleHandlerRegistry
    ) {
    }

    /**
     * @param mixed                  $value
     * @param RuleInterface|iterable $rules
     * @param bool                   $stopOnError
     *
     * @return Error[]
     */
    public function validate(mixed $value, RuleInterface|iterable $rules, bool $stopOnError = true): array
    {
        if ($rules instanceof RuleInterface) {
            $rules = [$rules];
        }

        $errors = [];

        foreach ($rules as $rule) {
            $ruleErrors = $this->ruleHandlerRegistry
                ->getRuleHandler(\get_class($rule))
                ->handle($value, $rule);

            $ruleErrors = iterator_to_array($ruleErrors);

            if ($ruleErrors) {
                $errors = array_merge($errors, $ruleErrors);

                if ($stopOnError) {
                    break;
                }
            }
        }

        return $errors;
    }
}
