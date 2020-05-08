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

    public $envNeeds = [
        'DB_CONNECTION',
        'DB_HOST',
        'DB_PORT',
        'DB_DATABASE',
        'DB_USERNAME',
        'DB_PASSWORD'
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
        if (empty($this->envNeeds)) {
            return;
        }
        foreach ($this->envNeeds as $envNeed) {
            if (!getenv($envNeed)) {
                throw new RuntimeException('missing from the env file "' . $envNeed . '"');
            }
        }
    }
}