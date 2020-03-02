<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\DeliveryService;
use App\Entity\Discount;
use App\Entity\Order;
use App\Entity\PrivateClient;
use App\Entity\Product;

class OrdersExample2Controller extends AppController
{
    public function showExample()
    {
        $client = Client::getById($this->app->getPdo(), 3);
        $order = $this->createOrder($client);
        $this->addProducts($order);
        $this->addDeliveries($order);
        $this->addDiscounts($order);
    }

    /**
     * @param Client $client
     * @return Order
     */
    private function createOrder(Client $client): Order
    {
        $order = $client->createOrder($this->app->getPdo());
        $this->app->getResponse()->supplementBody(
            '1. Создан пустой заказ >> ' . PHP_EOL . json_encode(
                Order::getById($this->app->getPdo(), $order->getId())
                     ->fetchToAssoc(),
                JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
            ) . PHP_EOL . PHP_EOL
        );
        return $order;
    }

    /**
     * @param Order $order
     */
    private function addProducts(Order $order): void
    {
        $order->getContents()->addProduct(
            Product::getById($this->app->getPdo(), 5)
        );
        $order->getContents()->addProduct(
            Product::getById($this->app->getPdo(), 6)
        );
        $order->getContents()->addProduct(
            Product::getById($this->app->getPdo(), 7)
        );
        $order->getContents()->update($order);

        $this->app->getResponse()->supplementBody(
            '2. В заказ добавлены товары >>' . PHP_EOL . json_encode(
                Order::getById($this->app->getPdo(), $order->getId())
                     ->fetchToAssoc(),
                JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
            ) . PHP_EOL . PHP_EOL
        );
    }

    /**
     * @param Order $order
     */
    private function addDeliveries(Order $order): void
    {
        $order->getContents()->addDeliveryService(
            DeliveryService::getById($this->app->getPdo(), 2)
        );
        $order->getContents()->update($order);

        $this->app->getResponse()->supplementBody(
            '3. В заказ добавлены службы доставки >>' . PHP_EOL . json_encode(
                Order::getById($this->app->getPdo(), $order->getId())
                     ->fetchToAssoc(),
                JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT,
            ) . PHP_EOL . PHP_EOL
        );
    }

    /**
     * @param Order $order
     */
    private function addDiscounts(Order $order)
    {
        $order->getContents()->addDiscount(
            Discount::getById($this->app->getPdo(), 2)
        );
        $order->getContents()->addDiscount(
            Discount::getById($this->app->getPdo(), 1)
        );
        $order->getContents()->update($order);

        $this->app->getResponse()->supplementBody(
            '4. К заказу добавлены скидки >>' . PHP_EOL . json_encode(
                Order::getById($this->app->getPdo(), $order->getId())
                     ->fetchToAssoc(),
                JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
            ) . PHP_EOL . PHP_EOL
        );
    }
}