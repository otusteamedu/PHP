<?php
declare(strict_types=1);

namespace DesignPatterns\Meals;

class HotDog implements MealInterface
{
    /**
     * @return string
     */
    public function cook(): string
    {
        return 'HotDog';
    }
}
