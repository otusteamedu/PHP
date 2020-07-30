<?php

namespace App\Providers;

use App\Controllers\OrderController;
use Classes\Repositories\DeliveryRepositoryImpl;
use Classes\Repositories\OrderClientRepositoryImpl;
use Classes\Repositories\OrderRepositoryImpl;
use DI\Container;
use Services\DeliveryServiceImpl;
use Services\DiscountServiceImpl;
use Services\OrderServiceImpl;
use Services\PriceServiceImpl;


class ServiceProvider
{

    public function register(Container $container): void
    {
        $container->set(OrderServiceImpl::class, static function (Container $c) {
            $orderRepository = $c->get(OrderRepositoryImpl::class);
            $deliveryRepository = $c->get(DeliveryRepositoryImpl::class);
            $priceService = $c->get(PriceServiceImpl::class);
            $orderClientRepository = $c->get(OrderClientRepositoryImpl::class);
            return new OrderServiceImpl($orderRepository, $deliveryRepository, $priceService, $orderClientRepository);
        });

        $container->set(PriceServiceImpl::class, static function (Container $c) {
            $discountService = $c->get(DiscountServiceImpl::class);
            $deliveryService = $c->get(DeliveryServiceImpl::class);
            return new PriceServiceImpl($discountService, $deliveryService);
        });

        $container->set(OrderController::class, static function (Container $c) {
            $orderService = $c->get(OrderServiceImpl::class);
            return new OrderController($orderService);
        });
    }
}
