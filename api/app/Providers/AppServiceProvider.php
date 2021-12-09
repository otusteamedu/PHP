<?php

namespace App\Providers;

use App\Services\Estate\Repositories\CacheEstateRepository;
use App\Services\Estate\Repositories\EloquentEstateRepository;
use App\Services\Estate\Repositories\EstateRepositoryInterface;
use App\Services\Users\Repositories\EloquentUserRepository;
use App\Services\Users\Repositories\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $bindings = [
        UserRepositoryInterface::class => EloquentUserRepository::class,
        EstateRepositoryInterface::class => CacheEstateRepository::class,
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
