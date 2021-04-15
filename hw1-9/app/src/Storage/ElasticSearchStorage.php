<?php

namespace Src\Storage;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Src\Models\Channel;
use Src\Models\Video;
use Src\StructuresReader\ElasticSearchStructureReader;

/**
 * Class ElasticSearch
 *
 * @package Src\Storage
 */
class ElasticSearchStorage
{
    protected Client $client;

    public function __construct()
    {
        $elasticSearchClient = ClientBuilder::create();
        $elasticSearchClient->setHosts([$_ENV['ELASTICSEARCH_HOST']]);
        $this->client = $elasticSearchClient->build();
    }

    /**
     * @param $dto
     * @param $indexName
     *
     * @return bool
     * @throws \Exception
     */
    public function store($dto, $indexName): bool
    {
        $params = [
            'index' => $indexName,
            'body' => [],
        ];

        $structureReader = new ElasticSearchStructureReader($indexName);
        $properties = $structureReader->getPropertiesList();

        foreach ($properties as $property) {
            if (isset($dto->{$property})) {
                $params['body'][$property] = $dto->{$property};
            }
        }
        $result = $this->client->index($params);
        return isset($result['result']) && in_array($result['result'], ['updated', 'created'], true);
    }
}