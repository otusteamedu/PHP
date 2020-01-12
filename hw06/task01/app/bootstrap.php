<?php
// bootstrap.php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use App\Provider\CommandProvider;
use App\Provider\RenderProvider;
use App\Provider\WebProvider;
use App\Support\ServiceProviderInterface;
use App\Provider\AppProvider;
use App\Support\Config;
use UltraLite\Container\Container;

/*
 * Определяем окружение
 */
$env = getenv('APP_ENV');
if (!$env) $env = 'local';

/*
 * Строим конфиг
 */
$config = new Config(__DIR__ . DIRECTORY_SEPARATOR . 'config', $env, __DIR__);

/*
 * Определяем сервис-провайдеры
 */
$providers = [
    AppProvider::class,
    RenderProvider::class,
    WebProvider::class,
    CommandProvider::class,
];

/*
 * Создаем экземпляр контейнера
 */
$container = new Container([
    Config::class => function () use ($config) { return $config;},
]);

/*
 * Регистрируем сервисы
 */
foreach ($providers as $className) {
    if (!class_exists($className)) {
        /** @noinspection PhpUnhandledExceptionInspection */
        throw new Exception('Provider ' . $className . ' not found');
    }
    $provider = new $className;
    if (!$provider instanceof ServiceProviderInterface) {
        /** @noinspection PhpUnhandledExceptionInspection */
        throw new Exception($className . ' has not provider');
    }
    $provider->register($container);
}

/*
 * Возвращаем контейнер
 */
return $container;