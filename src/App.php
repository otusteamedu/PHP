<?php

namespace App;

use Dotenv\Dotenv;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run as ErrorHandler;

final class App
{
    public function __construct()
    {
        self::loadDotEnv();
        self::setErrorHandler();
    }

    private static function loadDotEnv(): void
    {
        Dotenv::createImmutable(__DIR__ . '/..')->load();
    }

    private static function setErrorHandler(): void
    {
        if (getenv('APP_ENV') === 'dev') {
            (new ErrorHandler())
                ->pushHandler(new PrettyPageHandler())
                ->register();
        }
    }

    public function run(): void
    {
        echo Task::run();
    }
}
