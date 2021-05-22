<?php

declare(strict_types=1);

namespace App\Model\Product\UseCase\Cook;

class CookProductCommand
{
    public string $productName;
    public bool   $isCustomRecipeUsed;
    public array  $ingredients;
}