<?php

namespace App\Providers;

use App\Services\Factories\ProductFactory\AbstractProductFactory;
use App\Services\Notifications\ScreenNotificator;
use App\Services\Observer\INotificator;
use Illuminate\Container\Container;

class AppServiceProvider
{
    /**
     * Создает связь между абстрактным классом и реальной фабрикой на основе $productName
     *
     * @param Container $container
     * @param string $productName
     * @param string $productSize
     */
    static public function bindProductFactory(Container$container, string $productName, string $productSize): void
    {
        $container->bind(
            AbstractProductFactory::class,
            function () use ($productName, $productSize) {
                $factory = match ($productName) {
                    'burger'        => 'App\Services\Factories\ProductFactory\BurgerFactory',
                    'sandwich'      => 'App\Services\Factories\ProductFactory\SandwichFactory',
                    'hotdog'        => 'App\Services\Factories\ProductFactory\HotDogFactory',
                    default         => 'FactoryDoesNotPresent'
                };
                return new $factory($productSize);
            }
        );
    }

    /**
     * Назначает провайдера уведомляющего об изменениях в процессе приготовления
     *
     * @param Container $container
     */
    static public function bindNotificator(Container $container): void
    {
        $container->bind(
            INotificator::class,
            match ($_ENV['NOTIFICATOR']) {
                'email'     => 'emailSender::Class',
                'sms'       => 'smsSender::Class',
                default     => ScreenNotificator::class
            }
        );
    }
}