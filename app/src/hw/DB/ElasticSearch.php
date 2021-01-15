<?php

namespace VideoPlatform\DB;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use VideoPlatform\helpers\ArrayHelper;
use VideoPlatform\interfaces\DBInterface;

class ElasticSearch implements DBInterface
{
    private Client $client;

    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setHosts([$_ENV['ELASTIC_SEARCH_HOST']])
            ->build();
    }

    /**
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function save(array $data): bool
    {
        $correctData = ArrayHelper::getCorrectFormat($this, $data);

        $result = $this->client->index($correctData);

        if ($result) {
            print_r($result);
            return true;
        }

        return false;
    }

    /**
     * @param $index
     * @param $id
     * @return array
     */
    public function findById($index, $id): array
    {
        $params = [
            'index' => $index,
            'id' => $id,
            'client' => [ 'ignore' => 404 ]
        ];

        $result = $this->client->get($params);

        if (!$result['found']) {
            throw new \Exception('not found');
        }

        return $result['_source'];
    }
}