<?php
declare(strict_types=1);

namespace DesignPatterns\Strategies;

use DesignPatterns\Meals\MealInterface;

class StrategyContext
{
    /**
     * @var StrategyInterface
     */
    private StrategyInterface $strategy;

    /**
     * StrategyContext constructor.
     *
     * @param StrategyInterface $strategy
     */
    public function __construct(StrategyInterface $strategy)
    {
        $this->strategy = $strategy;
    }

    /**
     * @param StrategyInterface $strategy
     *
     * @return void
     */
    public function setStrategy(StrategyInterface $strategy): void
    {
        $this->strategy = $strategy;
    }

    /**
     * @return MealInterface
     */
    public function prepareOrder(): MealInterface
    {
        return $this->strategy->prepareOrder();
    }
}
