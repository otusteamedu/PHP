<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\DeliveryService;
use App\Entity\Discount;
use App\Entity\Order;
use App\Entity\PrivateClient;
use App\Entity\Product;

class OrdersExample1Controller extends AppController
{
    public function showExample()
    {
        $client = $this->createClient();
        $order = $this->createOrder($client);
        $this->addProducts($order);
        $this->addDeliveries($order);
        $this->addDiscounts($order);
    }

    /**
     * @return Client
     */
    private function createClient(): Client
    {
        $client = new PrivateClient($this->app->getPdo());
        $client->setName('Андрей')->setAddress('Пермь')->create();
        $this->app->getResponse()->supplementBody(
            '1. Создан клиент >> ' . PHP_EOL . json_encode(
                Client::getById($this->app->getPdo(), $client->getId())
                      ->fetchToAssoc(),
                JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
            ) . PHP_EOL . PHP_EOL
        );
        return $client;
    }

    /**
     * @param Client $client
     * @return Order
     */
    private function createOrder(Client $client): Order
    {
        $order = $client->createOrder($this->app->getPdo());
        $this->app->getResponse()->supplementBody(
            '2. Создан пустой заказ >> ' . PHP_EOL . json_encode(
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
            Product::getById($this->app->getPdo(), 1)
        );
        $order->getContents()->addProduct(
            Product::getById($this->app->getPdo(), 2)
        );
        $order->getContents()->addProduct(
            Product::getById($this->app->getPdo(), 3)
        );
        $order->getContents()->addProduct(
            Product::getById($this->app->getPdo(), 4)
        );
        $order->getContents()->update($order);

        $this->app->getResponse()->supplementBody(
            '3. В заказ добавлены товары >>' . PHP_EOL . json_encode(
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
            DeliveryService::getById($this->app->getPdo(), 1)
        );
        $order->getContents()->addDeliveryService(
            DeliveryService::getById($this->app->getPdo(), 3)
        );
        $order->getContents()->update($order);

        $this->app->getResponse()->supplementBody(
            '4. В заказ добавлены службы доставки >>' . PHP_EOL . json_encode(
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
            Discount::getById($this->app->getPdo(), 1)
        );
        $order->getContents()->update($order);

        $this->app->getResponse()->supplementBody(
            '5. К заказу добавлены скидки >>' . PHP_EOL . json_encode(
                Order::getById($this->app->getPdo(), $order->getId())
                     ->fetchToAssoc(),
                JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
            ) . PHP_EOL . PHP_EOL
        );
    }
}