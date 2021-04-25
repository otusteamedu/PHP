<?php


namespace App\Shop;


class Burger extends AbstractFastFood
{

    public function __construct()
    {
        parent::__construct();
        $this->ingredients()->add('bride')->add('cheese')->add('tomato');
    }

    public function cook(): string
    {
        return 'Cooked Burger with ' . implode(', ', $this->ingredients()->getAll());
    }

}