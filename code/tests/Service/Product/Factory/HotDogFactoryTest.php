<?php


namespace Service\Product\Factory;


use PHPUnit\Framework\TestCase;
use App\Entity\HotDog;
use App\Service\Product\Factory\HotDogFactory;


class HotDogFactoryTest extends TestCase
{
    public function testCreateBurger()
    {
        $factory = new HotDogFactory();
        $this->assertInstanceOf(HotDogFactory::class, $factory);

        $hotDog = $factory->createProduct();
        $this->assertInstanceOf(HotDog::class, $hotDog);
    }

}
