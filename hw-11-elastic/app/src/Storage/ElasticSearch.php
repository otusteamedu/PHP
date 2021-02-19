<?php

namespace Storage;

use Config\Config;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Exception;
use Structures\ElasticStructureReader;

class ElasticSearch
{
    public const STORAGE_NAME = 'elasticsearch';

    private Client $client;

    public const INDEXES = [
        'channels',
    ];

    public function __construct()
    {
        $dbHost = Config::getInstance()->getItem(Storage::DB_HOST_CONFIG_KEY);

        $clientBuilder = ClientBuilder::create();
        $clientBuilder->setHosts([$dbHost]);
        $this->client = $clientBuilder->build();

        $this->prepareIndexes();
    }

    private function prepareIndexes()
    {
        foreach (self::INDEXES as $indexName) {
            if ($this->isIndexCreated($indexName) === false) {
                echo 'creating index ' . $indexName . PHP_EOL;
                $this->createIndex($indexName);
            }
        }
    }

    private function isIndexCreated(string $indexName): bool
    {
        $params = [
            'index' => [
                $indexName,
            ]
        ];

        try {
            $response = $this->client->indices()->getSettings($params);
        }
        catch (Exception $e) {
            return false;
        }

        return !isset($response['error']);
    }

    private function createIndex(string $indexName): bool
    {
        $structure = new ElasticStructureReader($indexName);

        $result = $this->client->indices()->create($structure->getStructure());

        return !empty($result['acknowledged']);
    }
}