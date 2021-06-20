<?php


namespace App\Providers;


use Illuminate\Support\Facades\Config;
use SwaggerLume\ServiceProvider;

class SwaggerServiceProvider extends ServiceProvider
{
    public function register()
    {
        parent::register();

        Config::set('swagger-lume.paths.annotations', realpath('App'));
    }
}