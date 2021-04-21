<?php


namespace Service\Product\Factory;


use App\Entity\Sandwich;
use App\Service\Product\Factory\SandwichFactory;
use PHPUnit\Framework\TestCase;

class SandwichFactoryTest extends TestCase
{
    public function testCreateSandwich()
    {
        $factory = new SandwichFactory();
        $this->assertInstanceOf(SandwichFactory::class, $factory);

        $sandwich = $factory->createProduct();
        $this->assertInstanceOf(Sandwich::class, $sandwich);
    }

    public function testCreateSandwiches()
    {
        $factory = new SandwichFactory();
        $sandwiches = $factory->createProducts(5);
        $this->assertCount(5, $sandwiches);
        $this->assertContainsOnlyInstancesOf(Sandwich::class, $sandwiches);
    }
}

