<?php


namespace Service\Product\Strategy;


use App\Entity\Burger;
use App\Entity\HotDog;
use App\Entity\Sandwich;
use App\Service\Container\Container;
use App\Service\Product\Factory\BurgerFactory;
use App\Service\Product\Factory\HotDogFactory;
use App\Service\Product\Factory\SandwichFactory;
use App\Service\Product\Strategy\ProductStrategy;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class ProductStrategyTest extends TestCase
{
    private ContainerInterface $container;

    protected function setUp(): void
    {
        parent::setUp();
        $this->container = new Container();
        $this->container->addDefinitions([
            BurgerFactory::class => fn() => new BurgerFactory(),
            HotDogFactory::class => fn() => new HotDogFactory(),
            SandwichFactory::class => fn() => new SandwichFactory(),
        ]);
    }

    public function testCanGetFactory()
    {
        $strategy = new ProductStrategy($this->container);

        $factory = $strategy->getFactory(Burger::TYPE);
        $this->assertInstanceOf(BurgerFactory::class, $factory);

        $factory = $strategy->getFactory(HotDog::TYPE);
        $this->assertInstanceOf(HotDogFactory::class, $factory);

        $factory = $strategy->getFactory(Sandwich::TYPE);
        $this->assertInstanceOf(SandwichFactory::class, $factory);
    }

    public function testThrowException()
    {
        $strategy = new ProductStrategy($this->container);

        $this->expectException(\InvalidArgumentException::class);
        $factory = $strategy->getFactory('Noname');
    }

}
