<?php

namespace App\Providers;

use App\Models\Channel;
use App\Models\Video;
use App\Observers\ChannelObserver;
use App\Observers\VideoObserver;
use App\Services\Youtube\Repositories\ElasticsearchSearchChannelRepository;
use App\Services\Youtube\Repositories\EloquentSearchChannelRepository;
use App\Services\Youtube\Repositories\EloquentSearchVideoRepository;
use App\Services\Youtube\Repositories\EloquentWriteChannelRepository;
use App\Services\Youtube\Repositories\EloquentWriteVideoRepository;
use App\Services\Youtube\Repositories\SearchChannelRepository;
use App\Services\Youtube\Repositories\SearchVideoRepository;
use App\Services\Youtube\Repositories\Statistics\ElasticsearchViewChannelRepository;
use App\Services\Youtube\Repositories\Statistics\EloquentViewChannelRepository;
use App\Services\Youtube\Repositories\WriteChannelRepository;
use App\Services\Youtube\Repositories\Statistics\ViewChannelRepository;
use App\Services\Youtube\Repositories\WriteVideoRepository;
use Elasticsearch\Client as ElasticsearchClient;
use Elasticsearch\ClientBuilder;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public $bindings = [
        //SearchChannelRepository::class => EloquentSearchChannelRepository::class,
        SearchChannelRepository::class => ElasticsearchSearchChannelRepository::class,
        SearchVideoRepository::class => EloquentSearchVideoRepository::class,
        WriteChannelRepository::class => EloquentWriteChannelRepository::class,
        WriteVideoRepository::class => EloquentWriteVideoRepository::class,
        //ViewChannelRepository::class => EloquentViewChannelRepository::class,
        ViewChannelRepository::class => ElasticsearchViewChannelRepository::class,
        ];
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->bindSearchClient();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Подписываемся на события моделей Channel и Video
        Channel::observe(ChannelObserver::class);
        Video::observe(VideoObserver::class);
    }

    /**
     * Устанавливает связь класса ElasticsearchClient::class c сервером(ами) Elasticsearch
     * Грубо говоря здесь подключаем Эластику к проекту.
     * Так же необходимо с services прописать
     * 'elasticsearch' => [
             'enabled' => env('ELASTICSEARCH_ENABLED', true),
               'hosts' => explode(',', env('ELASTICSEARCH_HOSTS')),
        ],
     * в файле .env прописать значение для параметрв ELASTICSEARCH_HOSTS, в котором указывается физическое положение сервера
     * и для удобной работы установить клиента с помощью команды: composer require elasticsearch/elasticsearch
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
