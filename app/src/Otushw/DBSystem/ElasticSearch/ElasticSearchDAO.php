<?php


namespace Otushw\DBSystem\ElasticSearch;

use Elasticsearch\ClientBuilder;
use Otushw\DBSystem\NoSQLDAO;
use Otushw\DBSystem\IndexDTO;
use Exception;

class ElasticSearchDAO extends NoSQLDAO
{
    private $client;
    private $struct;
    private $indexName;


    public function __construct(IndexDTO $index)
    {
        parent::__construct($index);

        $clientBuilder = ClientBuilder::create();
        $clientBuilder->setHosts([$_ENV['DB_HOST']]);
        $this->client = $clientBuilder->build();

        $this->struct = array_keys($this->index->getIndexStruct());

        $this->indexName = $this->index->getIndexName();
    }

    public function create(array $source): bool
    {
        $response = $this->index($source);
        if (!empty($response['result']) && $response['result'] == 'created') {
            return true;
        }
        return false;
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
                    'properties' => $this->index->getIndexStruct()
                ]
            ]
        ];
        $result = $this->client->indices()->create($params);
        if (!empty($result['acknowledged'])) {
            return true;
        }
    }


    public function getIndex()
    {
        $params = [
            'index' => [ 'video' ]
        ];
        $response = $this->client->indices()->getSettings($params);
        var_dump($response);
    }

    private function index(array $source)
    {
        $params = [
            'index' => $this->indexName,
            'body' => []
        ];

        foreach ($this->struct as $item) {
            if (!isset($source[$item])) {
                throw new Exception($item . 'is missing');
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
