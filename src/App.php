<?php

namespace App;

use App\Console\AddIndex;
use App\Console\ChannelLikes;
use App\Console\SearchAndFill;
use App\Console\Top;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Symfony\Component\Console\Application;
use Whoops\Handler\PlainTextHandler;
use Whoops\Run as ErrorRunner;

final class App
{
    private static ?Db $db = null;

    public function __construct()
    {
        self::setErrorHandler();
        if ('cli' === PHP_SAPI) {
            self::setConsoleCommands();
        }
    }

    public static function getDb(): Db
    {
        if (null === self::$db) {
            self::$db = new Mongo();
        }
        return self::$db;
    }

    private static function setErrorHandler(): void
    {
        $logger = new Logger('app_error');
        $logger->pushHandler(new StreamHandler(STDERR));

        $handler = new PlainTextHandler($logger);
        $handler->loggerOnly(true);

        if (getenv('APP_ENV') === 'prod') {
            $handler->loggerOnly(true);
        }

        (new ErrorRunner())
            ->pushHandler($handler)
            ->register();
    }

    private static function setConsoleCommands(): void
    {
        $console = new Application();

        if (getenv('APP_ENV') === 'prod') {
            $console->setCatchExceptions(false);
        }

        $console->add(new SearchAndFill());
        $console->add(new AddIndex());
        $console->add(new Top());
        $console->add(new ChannelLikes());

        /** @noinspection PhpUnhandledExceptionInspection */
        $console->run();
    }
}
