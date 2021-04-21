<?php


namespace Entity;


use App\Entity\Burger;
use App\Entity\Ingredient;
use PHPUnit\Framework\TestCase;

class BurgerTest extends TestCase
{

    public function testBurger()
    {
        $burger = new Burger();
        $this->assertInstanceOf(Burger::class, $burger);
        $this->assertEquals('Бургер', $burger->getType());
    }

    public function testGetType()
    {
        $burger = new Burger();
        $type = $burger->getType();
        $this->assertSame('Бургер', $type);
    }

    public function testClone()
    {
        $burger = new Burger();
        $burgerClone = clone $burger;
        $this->assertNotSame($burger, $burgerClone);
    }

}
