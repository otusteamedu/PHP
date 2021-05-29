<?php
namespace Src\Services;

use Src\Observer\Observer;
use Src\Strategy\CookingStrategy;

class RestaurantService
{
    private CookingStrategy $strategy;

    public function __construct(CookingStrategy $strategy)
    {
        $this->strategy = $strategy;
    }

    public function prepareOrder(): void
    {
        try {
            $subjectFoodFactory = $this->strategy->chooseMealToCook()->cookFood();
            $foodName = $subjectFoodFactory->getFoodName();
            echo 'Let`s cook some ' . $foodName . '!' . PHP_EOL;
            $observer = new Observer();
            $subjectFoodFactory->attach($observer);
            $observer->askForExtra($subjectFoodFactory);
            $subjectFoodFactory->notify();
        } catch (\Exception $e) {
            echo $e->getMessage() . PHP_EOL;
        }
    }
}
