<?php

namespace App\Services\ServiceContainer;

use App\Repositories\Film\FilmPDORepository;
use App\Repositories\Film\FilmRepository;
use App\Services\Database\DB;
use App\Services\Database\PostgreSQL\PostgresSqlDB;
use App\Services\RabbitMQ\Client;
use App\Services\RabbitMQ\Manager;
use App\Services\RabbitMQ\EventDispatcher;
use App\Services\RabbitMQ\ConsumerMessageLogger;
use App\Services\ServiceContainer\Exceptions\ServiceNotFoundException;

class AppServiceContainer
{
    private array $instances;
    private static ?self $instance = null;

    private function __construct()
    {}

    public static function getInstance(): self
    {
        if(is_null(self::$instance)){
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function boot(): void
    {
        $this->push(DB::class, new PostgresSqlDB());
        $this->push(FilmRepository::class, new FilmPDORepository());

        $rabbitMQClient = new Manager(new Client);
        $this->push(Manager::class, $rabbitMQClient);
        $this->push(EventDispatcher::class, new EventDispatcher($rabbitMQClient));
    }

    /**
     * @param $key
     * @return mixed
     * @throws ServiceNotFoundException
     */
    public function resolve($key)
    {
        if(isset($this->instances[$key])){
            return $this->instances[$key];
        }

        throw new ServiceNotFoundException('Service: ' .$key . ' not found in Service Container');
    }

    private function push($key, $value): void
    {
        $this->instances[$key] = $value;
    }


}