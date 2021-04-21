<?php


namespace Service\Product\Factory;


use PHPUnit\Framework\TestCase;
use App\Entity\Burger;
use App\Service\Product\Factory\BurgerFactory;


class BurgerFactoryTest extends TestCase
{

    public function testCreateBurger()
    {
        $factory = new BurgerFactory();
        $this->assertInstanceOf(BurgerFactory::class, $factory);

        $burger = $factory->createProduct();
        $this->assertInstanceOf(Burger::class, $burger);

    }

    public function testCreateBurgers()
    {
        $factory = new BurgerFactory();
        $burgers = $factory->createProducts(5);

        $this->assertCount(5, $burgers);
        $this->assertContainsOnlyInstancesOf(Burger::class, $burgers);
    }

}
