<?php
declare(strict_types=1);

namespace DesignPatterns\Decorators;

use DesignPatterns\Meals\MealInterface;

class AbstractDecorator
{
    /**
     * @var MealInterface
     */
    protected MealInterface $meal;

    /**
     * AbstractDecorator constructor.
     *
     * @param array $chain
     */
    public function __construct(array $chain)
    {
        if (!empty($chain)) {
            $this->meal = static::makeChain($chain);
        }
    }

    /**
     * @param array $decoratorChain
     *
     * @return MealInterface
     */
    public static function makeChain(array $decoratorChain): MealInterface
    {
        $class = array_shift($decoratorChain);
        return new $class($decoratorChain);
    }
}
