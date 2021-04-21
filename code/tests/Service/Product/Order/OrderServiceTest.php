<?php


namespace Service\Product\Order;


use App\Entity\Burger;
use App\Service\Container\Container;
use App\Service\Mailer\EmailService;
use App\Service\Product\Order\ProductOrderService;
use App\Service\Product\Order\OrderSubjectInterface;
use App\Service\Product\Order\ProductOrderInterface;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class OrderServiceTest extends TestCase
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
        ]);
    }
    public function testCreateOrder()
    {
        $service = new ProductOrderService($this->container);

        $order = $service->createOrder('user@mail.com', Burger::TYPE);

        $this->assertInstanceOf(ProductOrderInterface::class, $order);
        $this->assertInstanceOf(OrderSubjectInterface::class, $order);
    }

}
