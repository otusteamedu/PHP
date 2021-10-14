<?php


namespace App\Services\Helpers\Recipes;


class SandwichRecipe
{
    private static string $size = 'Средний';

    private static string $base = 'Пшеничная';

    private static array $ingredients = [
        'cutlet'    => 'Говядина',
        'onion'     => 'Красный',
        'cheese'    => 'Чеддер',
    ];

    private static array $sauces = [
        'ketchup'   => 'Heinz',
    ];


    /**
     * @return string
     */
    public static function getSize(): string
    {
        return self::$size;
    }

    /**
     * @return string
     */
    public static function getBase(): string
    {
        return self::$base;
    }

    /**
     * @return array
     */
    public static function getIngredient(): array
    {
        return self::$ingredients;
    }

    /**
     * @return array
     */
    public static function getSauces(): array
    {
        return self::$sauces;
    }
}