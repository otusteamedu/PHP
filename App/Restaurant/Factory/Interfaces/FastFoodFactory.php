<?php


namespace App\Restaurant\Factory\Interfaces;


interface FastFoodFactory
{

    public function createBurger(): Burger;

    public function createSandwich(): Sandwich;

    public function createHotDog(): HotDog;

}