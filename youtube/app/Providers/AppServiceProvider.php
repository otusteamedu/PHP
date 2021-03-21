<?php

namespace App\Providers;

use App\Services\Channels\Repositories\ElasticSearchChannelRepository;
use App\Services\Channels\Repositories\EloquentSearchChannelRepository;
use App\Services\Channels\Repositories\Interfaces\SearchChannelRepositoryInterface;
use Elasticsearch\Client as ElasticsearchClient;
use Elasticsearch\ClientBuilder;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $bindings = [
        SearchChannelRepositoryInterface::class => ElasticSearchChannelRepository::class
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

    private function bindSearchClient()
    {
        var_dump(1);
        die();
        $this->app->bind(ElasticsearchClient::class, function () {
            return ClientBuilder::create()
                ->setHosts(config('services.elasticsearch.hosts'))
                ->build();
        });
    }
}
