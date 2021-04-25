<?php


namespace App\Shop\Decorators;


class ChickenFood extends Food
{
    public function cook(): string
    {
        $this->ingredients()->add('chicken');
        return parent::cook();
    }
}