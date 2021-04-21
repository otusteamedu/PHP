<?php


namespace Service\Product\Preparation;


use App\Entity\Sandwich;
use App\Observer\OrderObserver;
use App\Service\Mailer\EmailService;
use App\Service\Product\Factory\BurgerFactory;
use App\Service\Product\Factory\HotDogFactory;
use App\Service\Product\Factory\SandwichFactory;
use PHPUnit\Framework\TestCase;
use App\Service\Container\Container;
use App\Service\Product\Decorator\ProductDecorator;
use App\Service\Product\Order\ProductOrder;
use App\Service\Product\Preparation\ProductPreparationService;
use App\Service\Product\Strategy\ProductStrategy;
use Psr\Container\ContainerInterface;

class ProductPreparationServiceTest extends TestCase
{
    private ContainerInterface $container;

    protected function setUp(): void
    {
        $mailService = $this->createMock(EmailService::class);
        $mailService
            ->method('sendEmail')
            ->willReturn(true);

        parent::setUp();
        $this->container = new Container();
        $this->container->addDefinitions([
            EmailService::class => $mailService,
            BurgerFactory::class => fn() => new BurgerFactory(),
            HotDogFactory::class => fn() => new HotDogFactory(),
            SandwichFactory::class => fn() => new SandwichFactory(),
            ProductDecorator::class => fn() => new ProductDecorator(),
            ProductStrategy::class =>
                fn(ContainerInterface $container) => new ProductStrategy($container),
            ProductPreparationService::class =>
                fn(ContainerInterface $container) => new ProductPreparationService($container),
        ]);
    }

    public function testProcess()
    {
        $service = new ProductPreparationService($this->container);
        $order = new ProductOrder(
            'user@mail.com',
            'Сэндвич',
//            ['лук' => false, 'котлета' => false, 'соус' => true, 'горчица' => true]
        );
        $observer = new OrderObserver($this->container);
        $order->attach($observer);

        $product = $service->process($order);
        $this->assertInstanceOf(Sandwich::class, $product);
    }

}
