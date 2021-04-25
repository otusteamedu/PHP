<?php


namespace App\Shop\Factory\Interfaces;


interface FastFoodItem
{
    public function cook(): string;

    public function ingredients(): Ingredients;
}
