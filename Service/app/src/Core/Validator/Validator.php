<?php

namespace Service\Core\Validator;

use Service\Core\Validator\Rules\Email;

class Validator
{
    private array $rules;
    private array $values;
    private array $errors = [];

    private array $ruleClasses = [
        'email' => Email::class,
    ];

    public function __construct(array $rules, array $values)
    {
        $this->rules = $rules;
        $this->values = $values;
    }

    public static function make(array $rules, array $values)
    {
        return new self($rules, $values);
    }

    public function getErrors() : array
    {
        return $this->errors;
    }

    public function validate() : bool
    {
        foreach($this->rules as $fieldName => $ruleName){
            if(false === isset($this->ruleClasses[$ruleName])){
                continue;
            }

            $ruleClass = $this->initRule($this->ruleClasses[$ruleName]);
            $validateResult = $ruleClass->validate($this->values[$fieldName]);

            if(false === $validateResult){
                $this->errors[$fieldName] = $ruleClass->getInvalidMessage($fieldName);
            }
        }

        return $this->errors === [];
    }

    private function initRule(string $class) : RuleInterface
    {
        return new $class;
    }
}