<?php

namespace App;

use App\Console\Console;
use DI\Container;
use DI\ContainerBuilder;
use PDO;

final class App
{
    private static Container $container;

    /**
     * App constructor.
     *
     * @phan-suppress PhanNoopNew
     */
    public function __construct()
    {
        new ErrorHandler();
        self::setContainer();
        if ('cli' === PHP_SAPI) {
            new Console();
        } else {
            Router::dispatch();
        }
    }

    private static function setContainer() {
        /** @noinspection PhpUnhandledExceptionInspection */
        self::$container = (new ContainerBuilder())
            ->addDefinitions(
                [
                    PDO::class => static function () {
                        return new PDO(
                            getenv('APP_DB_DSN'),
                            getenv('APP_DB_USER'),
                            getenv('APP_DB_PWD'),
                            [
                                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                                PDO::ATTR_PERSISTENT => true,
                            ]
                        );
                    },
                ]
            )
            ->build();
    }

    public static function getEnv(): string
    {
        return getenv('APP_ENV') ?: 'prod';
    }

    public static function get(string $name)
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        return self::$container->get($name);
    }
}
