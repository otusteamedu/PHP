<?php


namespace App\Shop\Decorators;


class BeefFood extends Food
{
    public function cook(): string
    {
        $this->ingredients()->add('beef');
        return parent::cook();
    }
}