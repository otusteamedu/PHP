<?php


namespace App\Entity;


class Burger extends AbstractProduct
{
    const TYPE = 'Бургер';
    const DEFAULT_INGREDIENTS = [
        'котлета говяжья' => false,
        'томат' => false,
        'соленый огурец' => false];
    const BASE = 'булочка бриош';
    const AVAILABLE_INGREDIENTS = [
        'котлета куриная', 'котлета рыбная', 'бекон',
        'сыр', 'лук красный', 'перец болгарский',
    ];

    public function __construct()
    {
        $this->type = self::TYPE;
    }

    public function getDefaultOptions(): array
    {
        return self::DEFAULT_INGREDIENTS;
    }
}
