<?php


namespace Service\Product\Preparation;


use App\Entity\ProductInterface;
use App\Observer\OrderObserver;
use App\Service\Mailer\EmailService;
use App\Service\Product\Factory\BurgerFactory;
use App\Service\Product\Factory\HotDogFactory;
use App\Service\Product\Order\ProductOrderService;
use PHPUnit\Framework\TestCase;
use App\Service\Container\Container;
use App\Service\Product\Decorator\ProductDecorator;
use App\Service\Product\Strategy\ProductStrategy;
use App\Entity\Burger;
use App\Service\Product\Order\ProductOrder;
use App\Service\Product\Preparation\ProductPreparationProxy;
use App\Service\Product\Preparation\ProductPreparationService;
use Psr\Container\ContainerInterface;


class ProductPreparationProxyTest extends TestCase
{
    private ContainerInterface $container;

    protected function setUp(): void
    {
        parent::setUp();
        $this->container = new Container();
        $this->container->addDefinitions([
            EmailService::class => function () {
                $mailService = $this->createMock(EmailService::class);
                $mailService
                    ->method('sendEmail')
                    ->willReturn(true);
                return $mailService;
            },
            BurgerFactory::class => fn() => new BurgerFactory(),
            HotDogFactory::class => fn() => new HotDogFactory(),
            ProductDecorator::class => fn() => new ProductDecorator(),
            ProductStrategy::class =>
                fn(ContainerInterface $container) => new ProductStrategy($container),
            ProductPreparationService::class => function() {
                $service = $this->createMock(ProductPreparationService::class);
                $service
                    ->method('process')
                    ->willReturn(new Burger());

                return $service;
            },
        ]);
    }

    public function testPrepare()
    {
        $order = new ProductOrder(
            'user@mail.com',
            'Бургер'
        );
        $observer = new OrderObserver($this->container);
        $order->attach($observer);

        $proxy = new ProductPreparationProxy($this->container);

        $product = $proxy->process($order);
        $this->assertInstanceOf(Burger::class, $product);
    }

}
