<?php

namespace App\Providers;

use App\Contracts\Storage;
use App\Storage\RedisStorage;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class StorageServiceProvider extends ServiceProvider
{
    protected $defer = true;

    /**
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Storage::class, function (Application $app) {
            $driver = $app->make('config')->get('services.storage.driver');

            switch ($driver) {
                case 'redis':
                    return new RedisStorage();
                default:
                    throw new \RuntimeException('Invalid storage driver.');
            }
        });
    }

    /**
     * @return array
     */
    public function provides(): array
    {
        return [Storage::class];
    }
}
