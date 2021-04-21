<?php


namespace Entity;


use App\Entity\Ingredient;
use PHPUnit\Framework\TestCase;

class IngredientTest extends TestCase
{
    public function testIngredient()
    {
        $ingredient = new Ingredient('лук');
        $this->assertInstanceOf(Ingredient::class, $ingredient);
        $this->assertStringContainsString('лук', $ingredient);

        $ingredient->setDouble();
        $this->assertStringContainsString('лук (double)', $ingredient);
    }
}
