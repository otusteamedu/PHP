<?php

namespace App\Validator;

use InvalidArgumentException;

class Ruleset
{
    /** @var Rule[] */
    protected $rules = [];

    /**
     * @param Rule $rule
     * @return Ruleset
     */
    public function addRule(Rule $rule): Ruleset
    {
        if (! array_key_exists($rule->getName(), $this->rules)) {
            $this->rules[$rule->getName()] = $rule;
        }

        return $this;
    }

    /**
     * @param array $names
     * @return array
     */
    public function getRules(array $names = []): array
    {
        if (empty($names)) {
            return $this->rules;
        }

        $requiredRules = [];

        foreach ($this->rules as $rule) {
            if (in_array($rule->getName(), $names)) {
                $requiredRules[] = $rule;
            }
        }

        return $requiredRules;
    }

    /**
     * @param string $name
     * @return Rule
     */
    public function getRuleByName(string $name): Rule
    {
        if (array_key_exists($name, $this->rules)) {
            return $this->rules[$name];
        }

        $rule = $this->loadStandardRule($name);

        $this->rules[$rule->getName()] = $rule;

        return $rule;
    }

    /**
     * @param string $name
     * @return Rule
     * @throws InvalidArgumentException
     */
    protected function loadStandardRule(string $name): Rule
    {
        $className = $this->getClassName($name);

        if (! class_exists($className)) {
            throw new InvalidArgumentException("Rule $name does not exists");
        }

        return new $className;
    }

    /**
     * @param string $ruleName
     * @return string
     */
    protected function getClassName(string $ruleName): string
    {
        $ruleName = ucwords(str_replace(['-', '_'], ' ', $ruleName));
        $ruleName = str_replace(' ', '', $ruleName);

        return __NAMESPACE__ . '\Rules\\' . $ruleName . 'Rule';
    }
}
