<?php

declare(strict_types=1);

namespace App\Provider;

use App\Model\Channel\Repository\ChannelRepositoryInterface;
use App\Model\Channel\Repository\ElasticsearchChannelRepository;
use App\Model\Video\Repository\ElasticsearchVideoRepository;
use App\Model\Video\Repository\VideoRepositoryInterface;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Google_Client;
use Google_Service_YouTube;

class AppServiceProvider extends AbstractServiceProvider
{

    protected array $bindings = [
        ChannelRepositoryInterface::class => ElasticsearchChannelRepository::class,
        VideoRepositoryInterface::class   => ElasticsearchVideoRepository::class,
    ];

    protected function addMoreBindings(): void
    {
        $this->addBindElasticsearchClient();
        $this->addBindGoogleServiceYouTube();
    }

    private function addBindElasticsearchClient(): void
    {
        $this->bindings[Client::class] = function () {

            return ClientBuilder::create()
                                ->setHosts([$this->config->getParam('elasticsearch_host')])
                                ->build();

        };
    }

    private function addBindGoogleServiceYouTube(): void
    {
        $this->bindings[Google_Service_YouTube::class] = function () {
            $googleClient = new Google_Client();
            $googleClient->setDeveloperKey($this->config->getParam('google_api_key'));

            return new Google_Service_YouTube($googleClient);
        };
    }

}