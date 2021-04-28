<?php
declare(strict_types=1);

namespace App\Validator;

/**
 * Class RuleHandlerRegistry
 */
final class RuleHandlerRegistry
{
    /**
     * @var RuleHandlerInterface[]
     */
    private array $ruleHandlers = [];

    /**
     * @param iterable|RuleHandlerInterface[] $ruleHandlers
     */
    public function __construct(iterable $ruleHandlers)
    {
        foreach ($ruleHandlers as $ruleHandler) {
            $this->ruleHandlers[$ruleHandler::getRule()] = $ruleHandler;
        }
    }

    /**
     * @param string $rule
     *
     * @return RuleHandlerInterface
     */
    public function getRuleHandler(string $rule): RuleHandlerInterface
    {
        if (!isset($this->ruleHandlers[$rule])) {
            throw new RuleHandlerNotFoundException($rule);
        }

        return $this->ruleHandlers[$rule];
    }
}
