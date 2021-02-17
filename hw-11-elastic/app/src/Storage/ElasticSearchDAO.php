<?php

namespace Storage;

use Config\Config;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Exception;

class ElasticSearchDAO
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

        $response = $this->client->indices()->getSettings($params);

        return !isset($response['error']);
    }

    private function createIndex(string $indexName): bool
    {
        $params = [
            'index' => $indexName,
            'body' => [
                'mappings' => [
                    'properties' => $this->getStructure($indexName),
                    'dynamic' => 'strict'
                ]
            ]
        ];
        $result = $this->client->indices()->create($params);

        return !empty($result['acknowledged']);
    }

    private function getStructure($indexName)
    {
        $filename = $indexName . '.json';
        if (!file_exists('../../files/structures/' . $filename)) {
            throw new Exception($indexName . ' structure file is not found');
        }

        $json = file_get_contents('../../files/structures/' . $filename);

        return json_decode($json, true);
    }
}