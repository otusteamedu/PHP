<?php
declare(strict_types=1);

namespace DesignPatterns\Decorators;

use DesignPatterns\Meals\MealInterface;

class PepperDecorator extends AbstractDecorator implements MealInterface
{
    protected const PEPPER = 'pepper';

    /**
     * @return string
     */
    public function cook(): string
    {
        return sprintf('%s with %s', $this->meal->cook(), self::PEPPER);
    }
}
