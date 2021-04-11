<?php

namespace App\Services\ServiceContainer;

use App\Repositories\Channel\ChannelRepository;
use App\Repositories\Channel\ElasticSearchChannelRepository;
use App\Repositories\Event\EventRepository;
use App\Repositories\Event\RedisEventRepository;
use App\Repositories\Film\FilmPDORepository;
use App\Repositories\Film\FilmRepository;
use App\Repositories\Video\ElasticSearchVideoRepository;
use App\Repositories\Video\VideoRepository;
use App\Services\Database\DB;
use App\Services\Database\PostgreSQL\PostgresSqlDB;
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
        $this->push(ChannelRepository::class, new ElasticSearchChannelRepository());
        $this->push(VideoRepository::class, new ElasticSearchVideoRepository());
        $this->push(EventRepository::class, new RedisEventRepository());
        $this->push(DB::class, new PostgresSqlDB());
        $this->push(FilmRepository::class, new FilmPDORepository());
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