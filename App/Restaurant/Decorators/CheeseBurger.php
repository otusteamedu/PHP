<?php


namespace App\Restaurant\Decorators;


use App\Restaurant\Factory\Interfaces\Burger;
use App\Restaurant\Factory\Interfaces\Ingredients;
use http\Exception;

class CheeseBurger extends BurgerDecorator
{


    public function cook(): string
    {
        $this->ingredients()->add('cheese');
        return parent::cook();
    }

}