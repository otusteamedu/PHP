<?php

namespace App\Providers;

use App\Controllers\OrderController;
use App\Controllers\PublisherController;
use App\Controllers\SubscriberController;
use Classes\Queue\BrokerManager;
use Classes\Repositories\DeliveryRepositoryImpl;
use Classes\Repositories\OrderClientRepositoryImpl;
use Classes\Repositories\OrderRepositoryImpl;
use Classes\Repositories\PackageRepositoryInterfaceImpl;
use DI\Container;
use Services\BrokerServiceInterfaceImpl;
use Services\DeliveryServiceImpl;
use Services\DiscountServiceImpl;
use Services\OrderServiceImpl;
use Services\PackageServiceImpl;
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

        $container->set(DeliveryServiceImpl::class, static function (Container $c) {
            $packageService= $c->get(PackageServiceImpl::class);
            return new DeliveryServiceImpl($packageService);
        });

        $container->set(PackageServiceImpl::class, static function (Container $c) {
            $packageRepository= $c->get(PackageRepositoryInterfaceImpl::class);
            return new PackageServiceImpl($packageRepository);
        });

        $container->set(OrderController::class, static function (Container $c) {
            $orderService = $c->get(OrderServiceImpl::class);
            return new OrderController($orderService);
        });

        $container->set(BrokerServiceInterfaceImpl::class, static function (Container $c) {
            $brokerManager = new BrokerManager();
            $broker = $brokerManager->getBroker();

            return new BrokerServiceInterfaceImpl($broker);
        });

        $container->set(PublisherController::class, static function (Container $c) {
            $brokerService = $c->get(BrokerServiceInterfaceImpl::class);
            return new PublisherController($brokerService);
        });

        $container->set(SubscriberController::class, static function (Container $c) {
            $brokerService = $c->get(BrokerServiceInterfaceImpl::class);
            return new SubscriberController($brokerService);
        });
    }
}
