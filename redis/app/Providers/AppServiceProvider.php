<?php

namespace App\Providers;

use App\Services\Events\Repositories\Interfaces\CacheEventRepositoryInterface;
use App\Services\Events\Repositories\RedisCacheEventRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $bindings = [
        CacheEventRepositoryInterface::class => RedisCacheEventRepository::class
    ];
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
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
}
