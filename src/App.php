<?php

namespace App;

use Dotenv\Dotenv;
use Whoops\Handler\PlainTextHandler;
use Whoops\Run as ErrorRunner;

final class App
{
    public function __construct()
    {
        self::setEnv();
        self::setErrorRunner();
    }

    private static function setEnv(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/..', 'default.env');
        $dotenv->load();
        $dotenv->required('APP_ENV')->allowedValues(['prod', 'dev']);
    }

    private static function setErrorRunner(): void
    {
        (new ErrorRunner())
            ->pushHandler(new PlainTextHandler())
            ->register();
    }

    public function run(): void
    {
        Task::run();
    }
}
