<?php

namespace Src\Strategy;

class CookingStrategy
{
    private Strategy $strategy;

    private string $order;

    public function __construct(string $order)
    {
        $this->strategy = new PrepareStrategy();
        $this->order = $order;
    }

    /**
     * @throws \Exception
     */
    public function chooseMealToCook()
    {
        return $this->strategy->chooseDishesToCook($this->order);
    }
}