<?php

namespace App\Validator;

interface RulesetInterface
{
    /**
     * @param Rule $rule
     * @return RulesetInterface
     */
    public function addRule(Rule $rule): RulesetInterface;

    /**
     * @param array $names
     * @return array
     */
    public function getRules(array $names = []): array;

    /**
     * @param string $name
     * @return Rule
     */
    public function getRuleByName(string $name): Rule;
}
