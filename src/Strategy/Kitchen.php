<?php


namespace Src\Strategy;


use Src\AbstractFactory\FoodFactory;

class Kitchen
{
    private Strategy $strategy;

    private string $order;

    public function __construct(string $order)
    {
        $this->strategy = new CookStrategy();
        $this->order = $order;
    }

    /**
     * @throws \Exception
     */
    public function chooseMealToCook(): FoodFactory
    {
        return $this->strategy->chooseMealToCook($this->order);
    }
}