<?php

namespace App\Services\Location;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class LocationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('UserLocation', UserLocation::class);
        $loader = AliasLoader::getInstance();
        $loader->alias('UserLocation', UserLocation::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
