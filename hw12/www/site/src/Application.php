<?php

namespace App;

use App\DB\Db;
use App\Routes\Route;
use Dotenv\Dotenv;
use RuntimeException;

/**
 * Class Application
 * @package App
 */
class Application {

    public function start(): bool
    {
        (Dotenv::createImmutable(dirname(__DIR__) , '/.env'))->load();

        if(!getenv('DB_CONNECTION')) {
            throw new RuntimeException('missing from the env file "DB_CONNECTION"');
        }

        if(!getenv('DB_HOST')) {
            throw new RuntimeException('missing from the env file "DB_HOST"');
        }

        if(!getenv('DB_PORT')) {
            throw new RuntimeException('missing from the env file "DB_PORT"');
        }

        if(!getenv('DB_DATABASE')) {
            throw new RuntimeException('missing from the env file "DB_DATABASE"');
        }

        if(!getenv('DB_USERNAME')) {
            throw new RuntimeException('missing from the env file "DB_USERNAME"');
        }

        if(!getenv('DB_PASSWORD')) {
            throw new RuntimeException('missing from the env file "DB_PASSWORD"');
        }

        $router = new Route();
        $router->init();
    }
}
