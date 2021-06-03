<?php


namespace App;


use App\Amqp\Connection;
use App\Console\Command;
use App\Controllers\FormController;
use App\Shop\Adapters\IceCreamAdapter;
use App\Shop\Factory\Interfaces\FastFoodFactory;
use Dotenv\Dotenv;
use Dotenv\Repository\Adapter\EnvConstAdapter;
use Dotenv\Repository\Adapter\PutenvAdapter;
use Dotenv\Repository\RepositoryBuilder;
use Laravel\Lumen\Application;
use PhpAmqpLib\Connection\AMQPStreamConnection;

/**
 * Class App
 * @package App
 */
class App extends Application
{

    public function path()
    {
        return $this->basePath . DIRECTORY_SEPARATOR . 'App';
    }
}