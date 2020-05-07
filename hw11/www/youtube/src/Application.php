<?php

namespace App;

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

        if(!getenv('YOUTUBE_API_KEY')) {
            throw new RuntimeException('missing from the env file "YOUTUBE_API_KEY"');
        }

        $router = new Route();
        $router->init();

    }
}
