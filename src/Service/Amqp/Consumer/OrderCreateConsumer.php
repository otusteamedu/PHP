<?php

declare(strict_types=1);

namespace Service\Amqp\Consumer;

use Service\Database\PDOFactory;
use Service\DataMapper\OrderRequestMapper;
use Service\OrderFactory;

class OrderCreateConsumer extends AbstractConsumer
{
    private OrderFactory $orderFactory;
    private PDOFactory $pdoFactory;
    private OrderRequestMapper $orderRequestMapper;

    public function __construct()
    {
        parent::__construct();
        $this->orderFactory = new OrderFactory();
        $this->pdoFactory = new PDOFactory();
        $this->orderRequestMapper = new OrderRequestMapper($this->pdoFactory->getPostgresPDO());
    }

    public function operate(string $message): void
    {
        $message = json_decode($message, true);
        $orderData = json_decode($message['payload'], true);
        $order = $this->orderFactory->createOrder($orderData);
        $this->orderRequestMapper->updateOrderId((int)$message['request_id'], $order->getId());
    }

    protected function getExchangeName(): string
    {
        return 'order.create';
    }

    protected function getQueueName(): string
    {
        return 'order.create';
    }

    protected function getConsumerTag(): string
    {
        return 'order.create';
    }
}
