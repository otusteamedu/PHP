<?php

namespace App\Providers;

use App\Services\Event\Repositories\Eloquent\EloquentSearchEventRepository;
use App\Services\Event\Repositories\Eloquent\EloquentWriteEventRepository;
use App\Services\Event\Repositories\ISearchEventRepository;
use App\Services\Event\Repositories\IWriteEventRepository;
use App\Services\Event\Repositories\Redis\RedisSearchEventRepository;
use App\Services\Event\Repositories\Redis\RedisWriteEventRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->bindEventRepositories();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Устанавливает связи между различными хранилищами и репозиторием Event
     * Значение берется из config->services.php->events->repository
     */
    private function bindEventRepositories()
    {
        switch (config('services.event.repository')) {
            case 'redis':
                $this->app->bind(IWriteEventRepository::class, RedisWriteEventRepository::class);
                $this->app->bind(ISearchEventRepository::class, RedisSearchEventRepository::class);
                break;
            case 'eloquent':
            default:
                $this->app->bind(IWriteEventRepository::class, EloquentWriteEventRepository::class);
                $this->app->bind(ISearchEventRepository::class, EloquentSearchEventRepository::class);
                break;
        }
    }

}
