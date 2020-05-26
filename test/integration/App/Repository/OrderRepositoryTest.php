<?php

namespace Test\integration\App\Repository;

use App\Entity\OrderEntity;
use App\Repository\OrderRepository;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class OrderRepositoryTest extends TestCase
{
    /** @var \Psr\Container\ContainerInterface */
    private $container;

    protected function setUp(): void
    {
        parent::setUp();

        chdir(dirname(__DIR__, 4));
        require_once 'vendor/autoload.php';

        $this->container = include 'config/container.php';

        $loader = new Loader();
        $loader->loadFromDirectory($this->container->get('config')['fixture']['dir']);

        $executor = new ORMExecutor($this->container->get(EntityManagerInterface::class), new ORMPurger());
        $executor->execute($loader->getFixtures());
    }

    public function testFindOrderByNumber()
    {
        /** @var \App\Repository\OrderRepository $repository */
        $repository = $this->container->get(OrderRepository::class);
        $order = $repository->findByOrderNumber($orderNumber = '1234567890123456');

        self::assertInstanceOf(OrderEntity::class, $order, 'Order should be instance of OrderEntity');
        self::assertSame($orderNumber, $order->getNumber(), 'Wrong order number');
    }

    public function testNotFoundOrder()
    {
        $orderNumber = 'wrong_number';

        self::expectException(\DomainException::class);
        self::expectExceptionMessage("Order #{$orderNumber} not found.");

        $repository = $this->container->get(OrderRepository::class);
        $repository->findByOrderNumber($orderNumber);
    }

    public function testSetOrderIsPaid()
    {
        /** @var \App\Repository\OrderRepository $repository */
        $repository = $this->container->get(OrderRepository::class);
        $repository->setOrderIsPaid($orderNumber = '1234567890123456', 100.15);

        $order = $repository->findByOrderNumber($orderNumber);

        self::assertTrue($order->getIsPaid(), 'Order status should set is true');
    }

    public function testFailAlreadyPaid()
    {
        $orderNumber = '1234567890123457';
        self::expectExceptionMessage("Order #{$orderNumber} been paid.");

        /** @var \App\Repository\OrderRepository $repository */
        $repository = $this->container->get(OrderRepository::class);
        $repository->setOrderIsPaid($orderNumber, 200.50);
    }

    public function testFailSumNotMatch()
    {
        $orderNumber = '1234567890123457';
        self::expectExceptionMessage("Order #{$orderNumber} - sum is not match.");

        /** @var \App\Repository\OrderRepository $repository */
        $repository = $this->container->get(OrderRepository::class);
        $repository->setOrderIsPaid($orderNumber, 200.49);
    }
}
