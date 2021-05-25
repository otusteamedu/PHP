<?php
declare(strict_types=1);

namespace DesignPatterns;

use SplObjectStorage;
use DesignPatterns\Meals\MealInterface;
use DesignPatterns\Proxies\StrategyProxy;
use DesignPatterns\Strategies\StrategyContext;
use DesignPatterns\Observers\QualityAssuranceObserver;
use DesignPatterns\Strategies\DynamicStrategy;

class MealCookingController
{
    /**
     * @param array $ingredients
     * @param string $basis
     *
     * @return MealInterface
     */
    public function index(array $ingredients, string $basis): MealInterface
    {
        $proxy = new StrategyProxy(new DynamicStrategy($ingredients, $basis), new SplObjectStorage());
        $proxy->attach(new QualityAssuranceObserver());

        return (new StrategyContext($proxy))->prepareOrder();
    }
}
