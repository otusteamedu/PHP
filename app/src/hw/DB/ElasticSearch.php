<?php

namespace VideoPlatform\DB;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Exception;
use Monolog\Logger;
use VideoPlatform\helpers\ArrayHelper;
use VideoPlatform\interfaces\DBInterface;
use VideoPlatform\loggers\AppLogger;

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
     * @return mixed
     * @throws Exception
     */
    public function save(array $data)
    {
        $correctData = ArrayHelper::getCorrectFormat($this, $data);

        $result = $this->client->index($correctData);

        if ($result) {
            return $result['_id'];
        }

        return false;
    }

    /**
     * @param $index
     * @param $id
     * @return array
     * @throws Exception
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
            throw new Exception('not found');
        }

        return $result['_source'];
    }

    /**
     * @param $index
     * @param $queryParams
     * example:
     * [
     *  'where' => ['channelId' => 'someId']',
     *  'limit' => 100,
     *  'offset' => 0
     * ]
     * @return array|callable
     * @throws Exception
     */
    public function query($index, $queryParams = [])
    {
        $params = [
            'index' => $index,
            'body' => [
                'query' => [
                    'match' => $queryParams['where']
                ]
            ],
            'size' => $queryParams['limit'],
            'from' => $queryParams['offset'],
            'client' => [ 'ignore' => 404 ]
        ];

        $result = $this->client->search($params);

        if (empty($response['hits']['hits'])) {
            AppLogger::addLog(Logger::WARNING,'not found by query', $params);
        }

        return $result;
    }

    /**
     * получает все записи, по лимиту и офсету
     * @param $index
     * @param $limit
     * @param $offset
     * @return array|callable
     */
    public function getAll($index, $limit, $offset)
    {
        $params = [
            'index' => $index,
            'size' => $limit,
            'from' => $offset,
            'client' => [ 'ignore' => 404 ]
        ];

        $result = $this->client->search($params);

        if (empty($response['hits']['hits'])) {
            AppLogger::addLog(Logger::WARNING, 'not found by index: ' . $index, $params);
        }

        return $result;
    }
}