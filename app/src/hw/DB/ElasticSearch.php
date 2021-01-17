<?php

namespace VideoPlatform\DB;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Exception;
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
     * @throws Exception
     */
    public function save(array $data): bool
    {
        $correctData = ArrayHelper::getCorrectFormat($this, $data);

        $result = $this->client->index($correctData);

        if ($result) {
            echo ".";
            return true;
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

//        print_r($params);die;
        $result = $this->client->search($params);

        if (isset($response['hits']['hits']) && count($response['hits']['hits']) > 0) {
            echo 'not found => here is result : ';
            print_r($result);
        }

        return $result;
    }

    public function scroll($index)
    {
        $params = [
            'scroll' => '1s',
            'size' => 200,
            'index' => $index,
            'body' => [
                'query' => [
                    'match_all' => new \stdClass()
                ]
            ]
        ];

        $response = $this->client->search($params);

        while (isset($response['hits']['hits']) && count($response['hits']['hits']) > 0) {

            $scroll_id = $response['_scroll_id'];

            $response = $this->client->scroll([
                'body' => [
                    'scroll_id' => $scroll_id,
                    'scroll' => '1s'
                ]
            ]);
        }
    }

    public function getAll($index, $limit, $offset)
    {
        $params = [
            'index' => $index,
            'size' => $limit,
            'from' => $offset,
            'client' => [ 'ignore' => 404 ]
        ];

        $result = $this->client->search($params);

        if (isset($response['hits']['hits']) && count($response['hits']['hits']) > 0) {
            echo 'not found';
        }

        return $result;
    }
}