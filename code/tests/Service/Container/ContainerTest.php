<?php


namespace Service\Container;


use App\Entity\Burger;
use App\Service\Container\Container;
use App\Service\Container\Exception\NotFoundException;
use App\Service\Product\Preparation\ProductPreparationService;
use App\Service\Product\Strategy\ProductStrategy;

use PHPUnit\Framework\TestCase;
use stdClass;

class ContainerTest extends TestCase
{
    public function testSimpleData()
    {
        $container = new Container();
        $this->assertInstanceOf(Container::class, $container);

        $id = '123';
        $data = 'my string';

        $container->set($id, $data);

        $this->assertTrue($container->has($id));
        $this->assertEquals($data, $container->get($id));
    }

    public function testObjectInContainer()
    {
        $container = new Container();

        $id = Burger::class;
        $data = new Burger();

        $container->set($id, $data);

        $this->assertTrue($container->has($id));

        $burger = $container->get($id);
        $this->assertInstanceOf(Burger::class, $burger);

        $burger2 = $container->get($id);
        $this->assertSame($burger, $burger2);
    }


    public function testAddDefinitionsContainer()
    {
        $container = new Container();

        $definitions = [
            Burger::class => fn() => new Burger(),
            ProductPreparationService::class =>
                fn($container) => new ProductPreparationService($container),
        ];

        $container->addDefinitions($definitions);

        $this->assertTrue($container->has(Burger::class));

        $burger = $container->get(Burger::class);
        $this->assertInstanceOf(Burger::class, $burger);

        $burger2 = $container->get(Burger::class);
        $this->assertSame($burger, $burger2);

        $this->expectException(NotFoundException::class);
        $service = $container->get(ProductPreparationService::class);

        $container->addDefinitions([
            ProductStrategy::class => fn() => new ProductStrategy(),
        ]);
        $this->assertInstanceOf(ProductPreparationService::class, $service);

        $container->addDefinitions([stdClass::class => new stdClass()]);
        $stdClass = $container->get(stdClass::class);
        $this->assertInstanceOf(stdClass::class, $stdClass);
    }

}
