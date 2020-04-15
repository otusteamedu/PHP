<?php

namespace App;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Whoops\Handler\PlainTextHandler;
use Whoops\Run as ErrorRunner;

final class App
{
    public ?Db $db;

    public function __construct()
    {
        self::setErrorHandler();
        $this->db = new Mongo();
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
}
