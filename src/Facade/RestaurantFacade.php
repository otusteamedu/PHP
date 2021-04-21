<?php

namespace Src\Facade;

use Src\AbstractFactory\FoodFactory;
use Src\Services\KitchenService;
use Src\Strategy\Kitchen;

class RestaurantFacade
{
    private string $order;

    public function __construct(string $order)
    {
        $this->order = $order;
    }


    public function takeOrder(): void
    {
        try {
            $foodFactory = $this->chooseFoodToCook();
            $meal = $foodFactory->cookFood();
            $mealName = $meal->getFoodName();
            echo 'Let`s cook some ' . $mealName . '!' . PHP_EOL;
            $kitchen = new KitchenService();
            $meal->attach($kitchen);
            $kitchen->askForExtra($meal);
            $meal->notify();
            //var_dump($meal);
        } catch (\Exception $e) {
            echo $e->getMessage() . PHP_EOL;
        }
    }
    /**
     * @throws \Exception
     */
    private function chooseFoodToCook(): FoodFactory
    {
        $kitchen = new Kitchen($this->order);
        return $kitchen->chooseMealToCook();
    }
}