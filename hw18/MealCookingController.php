<?php
declare(strict_types=1);

namespace DesignPatterns;

use SplObjectStorage;
use DesignPatterns\Meals\MealInterface;
use DesignPatterns\Proxies\StrategyProxy;
use DesignPatterns\Strategies\StrategyContext;
use DesignPatterns\Observers\QualityAssuranceObserver;
use DesignPatterns\Strategies\BurgerWithEverythingStrategy;

class MealCookingController
{
    /**
     * @return MealInterface
     */
    public function index(): MealInterface
    {
        $proxy = new StrategyProxy(new BurgerWithEverythingStrategy(), new SplObjectStorage());
        $proxy->attach(new QualityAssuranceObserver());

        return (new StrategyContext($proxy))->prepareOrder();
    }
}
