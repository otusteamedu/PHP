<?php


namespace App\Service\Product\Order;


use App\Observer\OrderObserver;
use Psr\Container\ContainerInterface;

class ProductOrderService implements OrderServiceInterface
{
    private ContainerInterface $container;

    /**
     * ProductOrderService constructor.
     * @param \Psr\Container\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function createOrder(string $email, string $productType, array $productOptions = null): ProductOrderInterface
    {
        $order  = new ProductOrder($email, $productType, $productOptions);
        $orderObserver = new OrderObserver($this->container);
        $order->attach($orderObserver);

        return $order;
    }
}
