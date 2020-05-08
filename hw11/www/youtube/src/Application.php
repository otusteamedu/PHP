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

    public $envNeeds = [
        'YOUTUBE_API_KEY',
        'MONGO_HOST',
        'MONGO_USERNAME',
        'MONGO_PASSWORD',
        'MONGO_PORT'
    ];

    public function start(): bool
    {
        (Dotenv::createImmutable(dirname(__DIR__) , '/.env'))->load();

        $this->validateEnv();

        $router = new Route();
        $router->init();

    }

    public function validateEnv()
    {
        if(empty($this->envNeeds)) {
            return;
        }
        foreach ($this->envNeeds as $envNeed) {
            if(!getenv($envNeed)) {
                throw new RuntimeException('missing from the env file "'.$envNeed.'"');
            }
        }
    }
}
