<?php


namespace App\Restaurant\Decorators;


class BaconBurger extends BurgerDecorator
{
    public function cook(): string
    {
        $this->ingredients()->add('bacon');
        return parent::cook();
    }
}