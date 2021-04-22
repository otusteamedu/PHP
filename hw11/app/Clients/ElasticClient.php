<?php

namespace App\Clients;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;

/**
 * This class is needed for DI.
 *
 * Class YoutubeClient
 * @package App\Repositories
 */
class ElasticClient
{
    /**
     * @var Client|null
     */
    private ?Client $client;

    /**
     * @var self |null
     */
    private static ?self $instance = null;

    /**
     * ElasticClient constructor.
     */
    private function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setHosts([$_ENV['ELASTIC_HOST']])
            ->build()
        ;

        $config = json_decode(file_get_contents(dirname(__DIR__, 2) . '/config/elasticSchema.json'), true);

        foreach ($config as $indexParams){
            if(!isset($indexParams['index'])){
                continue;
            }

            if(false === $this->client->indices()->exists(['index' => $indexParams['index']])){
                $this->client->indices()->create($indexParams);
            }
        }
    }

    /**
     * @return Client
     */
    public static function getInstance(): Client
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance->client;
    }
}
