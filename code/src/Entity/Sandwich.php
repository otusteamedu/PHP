<?php


namespace App\Entity;


class Sandwich extends AbstractProduct
{
    const TYPE = 'Сэндвич';
    const DEFAULT_INGREDIENTS = [
        'бекон' => false,
        'капуста' => false,
        'помидор' => false];
    const BASE = 'белый хлеб';
    const AVAILABLE_INGREDIENTS = [
        'ветчина', 'вареная колбаса', 'сыр', 'лук красный', 'китайская капуста', 'укроп'
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
