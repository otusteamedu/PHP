<?php

namespace App\Controller;

use App\Core\Bootstrap;
use App\Entity\Client;
use App\Entity\DeliveryService;
use App\Entity\Discount;
use App\Entity\Order;
use App\Entity\Product;
use App\EntityFilter\ClientFilter;
use App\EntityFilter\DiscountFilter;
use App\EntityFilter\DeliveryServiceFilter;
use App\EntityFilter\OrderFilter;
use App\EntityFilter\ProductFilter;

class OrdersController extends JsonAppController
{
    private array $reqFilters = [];

    public function __construct(?Bootstrap $app = null)
    {
        parent::__construct($app);
        $this->reqFilters = $app->getRequest()->getFilters();
    }

    public function getOrders()
    {
        $orders = Order::getEntitiesByFilter(
            $this->app->getPdo(),
            OrderFilter::buildFromAssoc($this->reqFilters)
        );
        $this->app->getResponse()->setBody(
            json_encode(
                array_map(
                    fn(Order $order) => $order->fetchToAssoc(),
                    $orders
                ),
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
            )
        );
    }

    public function getProducts()
    {
        $products = Product::getEntitiesByFilter(
            $this->app->getPdo(),
            ProductFilter::buildFromAssoc($this->reqFilters)
        );
        $this->app->getResponse()->setBody(
            json_encode(
                array_map(
                    fn(Product $product) => $product->fetchToAssoc(),
                    $products
                ),
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
            )
        );
    }

    public function getDiscounts()
    {
        $discounts = Discount::getEntitiesByFilter(
            $this->app->getPdo(),
            DiscountFilter::buildFromAssoc($this->reqFilters)
        );
        $this->app->getResponse()->setBody(
            json_encode(
                array_map(
                    fn(Discount $discount) => $discount->fetchToAssoc(),
                    $discounts
                ),
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
            )
        );
    }

    public function getDeliveryServices()
    {
        $deliveryServices = DeliveryService::getEntitiesByFilter(
            $this->app->getPdo(),
            DeliveryServiceFilter::buildFromAssoc($this->reqFilters)
        );
        $this->app->getResponse()->setBody(
            json_encode(
                array_map(
                    fn(DeliveryService $service) => $service->fetchToAssoc(),
                    $deliveryServices
                ),
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
            )
        );
    }

    public function getClients()
    {
        $clients = Client::getEntitiesByFilter(
            $this->app->getPdo(),
            ClientFilter::buildFromAssoc($this->reqFilters)
        );
        $this->app->getResponse()->setBody(
            json_encode(
                array_map(
                    fn(Client $client) => $client->fetchToAssoc(),
                    $clients
                ),
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
            )
        );
    }
}