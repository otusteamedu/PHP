<?php


namespace App\Shop\Decorators;


class FishFood extends Food
{
    public function cook(): string
    {
        $this->ingredients()->add('fish');
        return parent::cook();
    }
}