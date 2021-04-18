<?php

namespace App\Restaurant\Factory\Interfaces;


interface Sandwich
{
    public function cook(): string;

    public function ingredients(): Ingredients;
}