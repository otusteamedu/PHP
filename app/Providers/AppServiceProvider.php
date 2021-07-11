<?php

namespace App\Providers;

use App\Services\Event\Repositories\Bla\Blabla;
use App\Services\Event\Repositories\Elastic\ElasticSearchEventRepository;
use App\Services\Event\Repositories\Elastic\ElasticWriteEventRepository;
use app\Services\Event\Repositories\Elasticsearch\ElasticsearchSearchEventRepository;
use app\Services\Event\Repositories\Elasticsearch\ElasticsearchWriteEventRepository;
use App\Services\Event\Repositories\Eloquent\EloquentSearchEventRepository;
use App\Services\Event\Repositories\Eloquent\EloquentWriteEventRepository;
use App\Services\Event\Repositories\ISearchEventRepository;
use App\Services\Event\Repositories\IWriteEventRepository;
use App\Services\Event\Repositories\Redis\RedisSearchEventRepository;
use App\Services\Event\Repositories\Redis\RedisWriteEventRepository;
use Elasticsearch\Client as ElasticsearchClient;
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
        $this->bindSearchClient();
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
            case 'elasticsearch':
                $this->app->bind(IWriteEventRepository::class, ElasticWriteEventRepository::class);
                $this->app->bind(ISearchEventRepository::class, ElasticSearchEventRepository::class);
                break;
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

    /**
     * Создает связь ElasticsearchClient::class с ClientBuilder - созданным экземпляром базы данных
     */
    private function bindSearchClient()
    {
        $this->app->bind(ElasticsearchClient::class, function () {
            return ClientBuilder::create()
                ->setHosts(config('services.elasticsearch.hosts'))
                ->build();
        });
    }

}
