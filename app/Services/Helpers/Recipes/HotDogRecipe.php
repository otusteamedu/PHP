<?php

namespace App\Services\Helpers\Recipes;

class HotDogRecipe
{
    private static string $size = 'Средний';

    private static string $base = 'Мягкая прожаренная';

    private static array $ingredients = [
        'sausage'   => 'Молочная',
        'cheese'    => 'Гауда',
    ];

    private static array $sauces = [
        'ketchup'   => 'Heinz',
        'mayonnaise' => 'Оливковый',
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