<?php

namespace Controllers;

use Elasticsearch\ClientBuilder;

class ElasticSearchController
{
    public $elasticSearch;
    public $host;

    public function __construct()
    {
        $this->host = $_ENV['ES_HOST'];
        $this->elasticSearch = ClientBuilder::create()->setHosts([$this->host])->build();
    }

    /**
     * @param array $params
     * @return array|callable
     */
    public function addDocument(array $params)
    {
        return $this->elasticSearch->index($params);
    }

    /**
     * @param array $params
     * @return array|callable
     */
    public function getDocument(array $params)
    {
        return $this->elasticSearch->get($params);
    }

    /**
     * @param array $params
     * @return array|callable
     */
    public function searchDocument(array $params)
    {
        return $this->elasticSearch->search($params);
    }

    /**
     * @param array $params
     * @return array|callable
     */
    public function deleteDocument(array $params)
    {
        return $this->elasticSearch->delete($params);
    }

}
