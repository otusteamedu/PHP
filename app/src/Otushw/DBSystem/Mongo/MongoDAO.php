<?php


namespace Otushw\DBSystem\Mongo;

use Otushw\DBSystem\NoSQLDAO;
use Otushw\DBSystem\IndexDTO;
use Exception;

class MongoDAO extends NoSQLDAO
{
    private $client;

    public function __construct(IndexDTO $index)
    {
        parent::__construct($index);
        $client = new \MongoDB\Client($_ENV['DB_HOST']);
        $indexName = $this->indexName;
        $collection = $client->demo->$indexName;
        var_dump($collection);

    }

    public function create(array $source): bool
    {
        $response = $this->index($source);
        if (!empty($response['result']) && $response['result'] == 'created') {
            return true;
        }
        return false;
    }

    /**
     * @param int $limit
     * @param int $offset
     *
     * @return array
     * @throws Exception
     */
    public function getItems($limit = 10, $offset = 0): array
    {
        $params = [
            'index' => $this->indexName,
            'size' => $limit,
            'from' => $offset,
        ];
        $response = $this->client->search($params);
        if (empty($response['hits'])) {
            throw new Exception('Can not get Items');
        }
        if (empty($response['hits']['hits'])) {
            return [];
        }
        $result = [];
        foreach ($response['hits']['hits'] as $key => $row) {
            foreach ($this->struct as $item) {
                if ($item == 'id') {
                    $result[$key]['id'] = $row['_id'];
                } else {
                    $result[$key][$item] = $row['_source'][$item];
                }
            }
        }
        return $result;
    }

    /**
     * @return int
     * @throws Exception
     */
    public function getCount(): int
    {
        $params = [
            'index' => $this->indexName,
        ];
        try {
            $response = $this->client->count($params);
        } catch (Exception $e) {
            $response = $this->processException($e);
        }
        if (empty($response['count'])) {
            throw new Exception('Does not return count from index Video');
        }
        return $response['count'];
    }

    public function getSumField($fieldName)
    {
        $params = [
            'index' => $this->indexName,
            'size' => 0,
            'body' => [
                'aggs' => [
                    $fieldName => [
                        'sum' => ['field' => $fieldName]
                    ]
                ]
            ]
        ];
        try {
            $response = $this->client->search($params);
        } catch (Exception $e) {
            $response = $this->processException($e);
        }
        if (empty($response)) {
            throw new Exception('Response is empty.');
        }
        if (empty($response['aggregations'])) {
            throw new Exception('Response has not aggregations.');
        }
        if (empty($response['aggregations'][$fieldName])) {
            throw new Exception('Aggregations has not ' . $fieldName. '.');
        }
        return $response['aggregations'][$fieldName]['value'];
    }

    public function read($id): array
    {
        $params = [
            'index' => $this->indexName,
            'id'    => $id
        ];
        try {
            $response = $this->client->get($params);
        } catch (Exception $e) {
            $response = $this->processException($e);
        }
        if (empty($response)) {
            throw new Exception('Response is empty.');
        }

        if (empty($response['found'])) {
            return [];
        }
        $result = [
            'id' => $response['_id']
        ];

        foreach ($this->struct as $item) {
            if ($item == 'id') {
                $result['id'] = $response['_id'];
            } else {
                $result[$item] = $response['_source'][$item];
            }
        }
        return $result;
    }

    public function update($id, array $source): bool
    {
        $exist = $this->read($id);
        if (empty($exist)) {
            throw new Exception('Item id:' . $id . ' does not exist.');
        }

        $source['id'] = $id;
        $response = $this->index($source);

        if (!empty($response['result']) && $response['result'] == 'updated') {
            return true;
        }
        return false;
    }

    public function delete($id): bool
    {
        $params = [
            'index' => $this->indexName,
            'id'    => $id
        ];
        try {
            $response = $this->client->delete($params);
        } catch (Exception $e) {
            $response = $this->processException($e);
        }
        if (!empty($response['result']) && $response['result'] == 'deleted') {
            return true;
        }
        return false;
    }

    public function createIndex()
    {
        $params = [
            'index' => $this->indexName,
            'body' => [
                'mappings' => [
                    'properties' => $this->index->getIndexStruct(),
                    'dynamic' => 'strict'
                ]
            ]
        ];
        $result = $this->client->indices()->create($params);
        if (!empty($result['acknowledged'])) {
            return true;
        }
        return false;
    }


    public function existIndex()
    {
        $params = [
            'index' => [$this->indexName]
        ];
        try {
            $response = $this->client->indices()->getSettings($params);
        } catch (Exception $e) {
            $response = $this->processException($e);
        }
        if (isset($response['error'])) {
            return false;
        }
        return true;
    }

    private function index(array $source)
    {
        $params = [
            'index' => $this->indexName,
            'body' => []
        ];

        foreach ($this->struct as $item) {
            if (!isset($source[$item])) {
                throw new Exception($item . ' is missing');
            }
            if ($item == 'id') {
                $params[$item] = $source[$item];
            } else {
                $params['body'][$item] = $source[$item];
            }
        }

        try {
            $response = $this->client->index($params);
        } catch (Exception $e) {
            $response = $this->processException($e);
        }
        return $response;
    }

    private function processException($e)
    {
        $msg = $e->getMessage();
        if ($this->isJSON($msg)) {
            return json_decode($msg, true);
        } else {
            throw new Exception($msg, $e->getCode());
        }
    }
}
