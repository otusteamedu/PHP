<?php
declare(strict_types=1);

namespace DesignPatterns\Decorators;

use DesignPatterns\Meals\MealInterface;

class SauceDecorator extends AbstractDecorator implements MealInterface
{
    protected const SAUCE = 'sauce';

    /**
     * @return string
     */
    public function cook(): string
    {
        return sprintf('%s with %s', $this->meal->cook(), self::SAUCE);
    }
}
