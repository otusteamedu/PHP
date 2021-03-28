<?php

namespace App\Providers;

use App\Services\Channels\Repositories\ChannelRepositoryInterface;
use App\Services\Channels\Repositories\ElasticChannelRepository;
use App\Services\Channels\Repositories\EloquentChannelRepository;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
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
        $this->app->bind(
            ChannelRepositoryInterface::class,
            function () {
                if (config('services.search.enabled')) {
                    return new ElasticChannelRepository($this->app->make(Client::class));
                }
                return new EloquentChannelRepository();
            }
        );

        $this->app->bind(
            \Google_Client::class, function () {
            $client = new \Google_Client();
            if (!empty(config('services.google.key'))) {
                $client->setDeveloperKey(config('services.google.key'));
            }
            return $client;
        });

        $this->app->bind(
            \Google_Service_YouTube::class, function () {
            return new \Google_Service_YouTube($this->app->make(\Google_Client::class));
        });

        $this->bindSearchClient();
    }

    private function bindSearchClient()
    {
        $this->app->bind(Client::class, function ($app) {
            return ClientBuilder::create()
                ->setHosts($app['config']->get('services.search.hosts'))
                ->build();
        });
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
