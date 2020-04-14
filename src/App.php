<?php

namespace App;

use Dotenv\Dotenv;
use Whoops\Handler\HandlerInterface;
use Whoops\Handler\JsonResponseHandler;
use Whoops\Handler\PlainTextHandler;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run as ErrorRunner;

final class App
{
    public ?Db $db;

    public function __construct()
    {
        self::setEnv();
        self::setErrorRunner();
        $this->db = new Mongo();
    }

    private static function setEnv(): void
    {
        $dotenv = Dotenv::createImmutable('/app', 'default.env');
        $dotenv->load();
        $dotenv->required('APP_ENV')->allowedValues(['prod', 'dev']);
    }

    private static function setErrorRunner(): void
    {
        $handler = self::getErrorHanler();
        if ($handler) {
            (new ErrorRunner())
                ->pushHandler($handler)
                ->register();
        }
    }

    private static function getErrorHanler(): ?HandlerInterface
    {
        if ('cli' === PHP_SAPI) {
            return new PlainTextHandler();
        }
        if (getenv('APP_ENV') === 'dev') {
            if (isset($_SERVER['HTTP_ACCEPT']) && false !== strpos($_SERVER['HTTP_ACCEPT'], 'application/json')) {
                return new JsonResponseHandler();
            }
            return new PrettyPageHandler();
        }
        return null;
    }
}
