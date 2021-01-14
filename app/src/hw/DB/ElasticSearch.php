<?php

namespace VideoPlatform\DB;

use Elasticsearch\ClientBuilder;
use VideoPlatform\helpers\ArrayHelper;
use VideoPlatform\interfaces\DBInterface;

class ElasticSearch implements DBInterface
{
    private $client;

    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setHosts([$_ENV['ELASTIC_SEARCH_HOST']])
            ->build();
    }

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

    public function findById($index, $id): array
    {
        $params = [
            'index' => $index,
            'id' => $id
        ];

        return $this->client->get($params);
    }
}