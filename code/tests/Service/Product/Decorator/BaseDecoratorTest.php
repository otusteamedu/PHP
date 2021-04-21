<?php


namespace Service\Product\Decorator;


use PHPUnit\Framework\TestCase;
use App\Entity\HotDog;
use App\Entity\Burger;
use App\Service\Product\Decorator\ProductDecorator;
use App\Service\Product\Factory\BurgerFactory;
use App\Service\Product\Factory\HotDogFactory;


class BaseDecoratorTest extends TestCase
{
    public function testBurgerAddIngredients()
    {
        $baseBurger = (new BurgerFactory())->createProduct();
        $decorator = new ProductDecorator();
        $decorator->setProduct($baseBurger);

        $product = $decorator->addIngredients(Burger::DEFAULT_INGREDIENTS);

        $this->assertInstanceOf(Burger::class, $product);
        $this->assertStringContainsString('Бургер', (string) $product);
    }

    public function testHotDogAddIngredients()
    {
        $baseHotDog = (new HotDogFactory())->createProduct();
        $decorator = new ProductDecorator();
        $decorator->setProduct($baseHotDog);

        $product = $decorator->addIngredients(HotDog::DEFAULT_INGREDIENTS);

        $this->assertInstanceOf(HotDog::class, $product);
    }

}
