<?php


use App\Service\Mailer\EmailService;
use App\Service\Product\Decorator\ProductDecorator;
use App\Service\Product\Factory\BurgerFactory;
use App\Service\Product\Factory\HotDogFactory;
use App\Service\Product\Factory\SandwichFactory;
use App\Service\Product\Order\ProductOrderService;
use App\Service\Product\Preparation\ProductPreparationProxy;
use App\Service\Product\Preparation\ProductPreparationService;
use App\Service\Product\Strategy\ProductStrategy;
use Psr\Container\ContainerInterface;


return [
    EmailService::class => function () {
        $host = getenv('SMTP_HOST');
        $port = getenv('SMTP_PORT');
        $username = getenv('SMTP_USERNAME');
        $password = getenv('SMTP_PASSWORD');

        return new EmailService($host, $port, $username, $password);
    },
    BurgerFactory::class => fn() => new BurgerFactory(),
    HotDogFactory::class => fn() => new HotDogFactory(),
    SandwichFactory::class => fn() => new SandwichFactory(),
    ProductOrderService::class =>
        fn(ContainerInterface $container) => new ProductOrderService($container),
    ProductDecorator::class => fn() => new ProductDecorator(),
    ProductStrategy::class =>
        fn(ContainerInterface $container) => new ProductStrategy($container),
    ProductPreparationService::class =>
        fn(ContainerInterface $container) => new ProductPreparationService($container),
    ProductPreparationProxy::class =>
        fn(ContainerInterface $container) => new ProductPreparationProxy($container),
];
