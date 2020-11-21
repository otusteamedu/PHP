<?php

namespace app\src;

use Elasticsearch\ClientBuilder;

class ElasticStorage
{
    private $client;


    public function __construct()
    {
        $this->client = ClientBuilder::create()->build();
    }


    /**
     * Add docuemnt to index
     *
     * @param $params
     *
     * @return array|callable
     */
    public function add($params)
    {
        return $this->client->index($params);
    }


    /**
     * Fetch document
     *
     * @param $params
     *
     * @return array|callable
     */
    public function fetch($params)
    {
        return $this->client->get($params);
    }


    /**
     * Delete document
     *
     * @param $params
     *
     * @return array|callable
     */
    public function delete($params)
    {
        return $this->client->delete($params);
    }


    /**
     * Create index
     *
     * @param $params
     *
     * @return array
     */
    public function createIndex($params)
    {
        return $this->client->indices()->create($params);
    }


    public function deleteIndex($params)
    {
        return $this->client->indices()->delete($params);
    }
}