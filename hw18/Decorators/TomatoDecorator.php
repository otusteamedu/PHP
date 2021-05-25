<?php
declare(strict_types=1);

namespace DesignPatterns\Decorators;

use DesignPatterns\Meals\MealInterface;

class TomatoDecorator extends AbstractDecorator implements MealInterface
{
    protected const TOMATO = 'tomato';

    /**
     * @return string
     */
    public function cook(): string
    {
        return sprintf('%s with %s', $this->meal->cook(), self::TOMATO);
    }
}
