<?php


namespace App\Shop\Decorators;


class KitchenFood extends Food
{
    public function cook(): string
    {
        $this->ingredients()->add('kitchen');
        return parent::cook();
    }
}