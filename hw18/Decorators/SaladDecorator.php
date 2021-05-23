<?php
declare(strict_types=1);

namespace DesignPatterns\Decorators;

use JetBrains\PhpStorm\Pure;
use DesignPatterns\Meals\MealInterface;

class SaladDecorator implements MealInterface
{
    protected const SALAD = 'salad';

    /**
     * @var MealInterface
     */
    protected MealInterface $meal;

    /**
     * SaladDecorator constructor.
     *
     * @param MealInterface $meal
     */
    #[Pure]
    public function __construct(MealInterface $meal)
    {
        $this->meal = $meal;
    }

    /**
     * @return string
     */
    public function cook(): string
    {
        return sprintf('%s with %s', $this->meal->cook(), self::SALAD);
    }
}
