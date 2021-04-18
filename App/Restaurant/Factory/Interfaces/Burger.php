<?php


namespace App\Restaurant\Factory\Interfaces;



interface Burger
{
    public function cook(): string;

    public function ingredients(): Ingredients;
}