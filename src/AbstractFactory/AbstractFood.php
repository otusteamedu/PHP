<?php

namespace Src\AbstractFactory;

use Src\Decorator\SpecialRecipe;

interface AbstractFood extends SpecialRecipe
{
    public function getFoodName() : string;
}