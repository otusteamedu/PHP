<?php


namespace App\Shop;


class Sandwich extends AbstractFastFood
{

    public function __construct()
    {
        parent::__construct();
        $this->ingredients()->add('pita bread')->add('salad');
    }

    public function cook(): string
    {
        return 'Cooked Sandwich with ' . implode(', ', $this->ingredients()->getAll());
    }
}