<?php

namespace App\Validator;

class Validator
{
    /** @var RulesetInterface */
    protected $ruleset;
    /** @var ErrorBagInterface */
    protected $errors;
    /** @var bool */
    protected $breakOnFirstError = false;
    /** @var bool */
    protected $failed = false;

    /**
     * @param RulesetInterface $ruleset
     * @param ErrorBagInterface $errorBag
     * @param bool $breakOnFirstError
     */
    public function __construct(RulesetInterface $ruleset, ErrorBagInterface $errorBag, bool $breakOnFirstError = false)
    {
        $this->ruleset = $ruleset;
        $this->errors = $errorBag;
        $this->breakOnFirstError = $breakOnFirstError;
    }

    /**
     * @param bool $value
     */
    public function breakOnFirstError(bool $value): void
    {
        $this->breakOnFirstError = $value;
    }

    /**
     * @return bool
     */
    public function failed(): bool
    {
        return $this->failed;
    }

    /**
     * @return ErrorBagInterface
     */
    public function errors(): ErrorBagInterface
    {
        return $this->errors;
    }

    /**
     * @param array $data
     * @param array $rules
     * @param array $messages
     * @return bool
     */
    public function validate(array $data, array $rules, array $messages = []): bool
    {
        $this->failed = false;
        $this->errors->clearAll();

        foreach ($rules as $fieldName => $items) {
            if (is_string($items)) {
                $explodedItems = explode('|', $items);
            } else {
                $explodedItems = $items;
            }

            foreach ($explodedItems as $ruleStr) {
                $ruleParams = RuleParams::parse($ruleStr);

                if ($ruleParams) {
                    $result = $this->ruleset
                        ->getRuleByName($ruleParams->name)
                        ->validate($data, $fieldName, $ruleParams->params, $messages);

                    if ($result->failed()) {
                        $this->failed = true;
                        $this->errors->add($fieldName, $result->message);

                        if ($this->breakOnFirstError) {
                            break 2;
                        }
                    }
                }
            }
        }

        return $this->failed();
    }

    /**
     * @param Rule $rule
     */
    public function addRule(Rule $rule): void
    {
        $this->ruleset->addRule($rule);
    }
}
