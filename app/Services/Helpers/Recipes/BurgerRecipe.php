<?php


namespace App\Services\Helpers\Recipes;


class BurgerRecipe
{
    private static string $size = 'Средний';

    private static string $base = 'С кунжутом';

    private static array $ingredients = [
        'steak'     => 'Средняя прожарка',
        'cheese'    => 'Чеддер',
        'onion'     => 'Зеленый репчатый',
    ];

    private static array $sauces = [
        'ketchup'   => 'Heinz',
        'mayonnaise' => 'Московский провансаль',
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