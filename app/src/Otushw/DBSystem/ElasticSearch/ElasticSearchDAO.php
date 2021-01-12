<?php


namespace Otushw\DBSystem\ElasticSearch;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Otushw\DBSystem\NoSQLDAO;
use AppException;
use Otushw\StorageInterface;
use Otushw\VideoDTO;

class ElasticSearchDAO extends NoSQLDAO
{
    private Client $client;
    const STORAGE_NAME = 'ElasticSearch';

    public function __construct()
    {
        $clientBuilder = ClientBuilder::create();
        $clientBuilder->setHosts([$_ENV['DB_HOST']]);
        $this->client = $clientBuilder->build();

        parent::__construct();
    }

    public function create(VideoDTO $source): bool
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
     * @throws AppException
     */
    public function getItems(int $limit = 10, int $offset = 0): array
    {
        $params = [
            'index' => $this->documentName,
            'size' => $limit,
            'from' => $offset,
        ];
        $response = $this->client->search($params);
        if (empty($response['hits'])) {
            throw new AppException('Can not get Items');
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
     * @throws AppException
     */
    public function getCount(): int
    {
        $params = [
            'index' => $this->documentName,
        ];
        try {
            $response = $this->client->count($params);
        } catch (AppException $e) {
            $response = $this->processException($e);
        }
        if (empty($response['count'])) {
            throw new Exception('Does not return count from index ' . $this->documentName);
        }
        return $response['count'];
    }

    /**
     * @param string $fieldName
     *
     * @return int
     * @throws Exception
     */
    public function getSumField(string $fieldName): int
    {
        $params = [
            'index' => $this->documentName,
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
        return (int) $response['aggregations'][$fieldName]['value'];
    }

    /**
     * @param int $id
     *
     * @return VideoDTO
     * @throws Exception
     */
    public function read(int $id): ?VideoDTO
    {
        $params = [
            'index' => $this->documentName,
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
            return null;
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

        return new VideoDTO(
            $result['id'],
            $result['title'],
            $result['viewCount'],
            $result['likeCount'],
            $result['disLikeCount'],
            $result['commentCount']
        );
    }

    /**
     * @param int   $id
     * @param VideoDTO $source
     *
     * @return bool
     * @throws Exception
     */
    public function update(int $id, VideoDTO $source): bool
    {
        $exist = $this->read($id);
        if (empty($exist)) {
            throw new Exception('Item id:' . $id . ' does not exist.');
        }

        $source->id = $id;
        $response = $this->index($source);

        if (!empty($response['result']) && $response['result'] == 'updated') {
            return true;
        }
        return false;
    }

    /**
     * @param int $id
     *
     * @return bool
     * @throws Exception
     */
    public function delete(int $id): bool
    {
        $params = [
            'index' => $this->documentName,
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

    /**
     * @param VideoDTO $source
     *
     * @return array
     * @throws Exception
     */
    private function index(VideoDTO $source): array
    {
        $params = [
            'index' => $this->documentName,
            'body' => []
        ];

        foreach ($this->struct as $item) {
            if (!isset($source->{$item})) {
                throw new Exception($item . ' is missing');
            }
            if ($item == 'id') {
                $params[$item] = $source->{$item};
            } else {
                $params['body'][$item] = $source->{$item};
            }
        }

        try {
            $response = $this->client->index($params);
        } catch (Exception $e) {
            $response = $this->processException($e);
        }
        return $response;
    }

    /**
     * @param Exception $e
     *
     * @return mixed
     * @throws Exception
     */
    private function processException(Exception $e)
    {
        $msg = $e->getMessage();
        if ($this->isJSON($msg)) {
            return json_decode($msg, true);
        } else {
            throw new Exception($msg, $e->getCode());
        }
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function existDocStruct(): bool
    {
        return $this->existIndex();
    }

    /**
     * @return bool
     * @throws Exception
     */
    private function existIndex(): bool
    {
        $params = [
            'index' => [$this->documentName]
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

    /**
     * @return bool
     */
    public function createDocStruct(): bool
    {
        return $this->createIndex();
    }

    /**
     * @return bool
     */
    private function createIndex(): bool
    {
        $params = [
            'index' => $this->documentName,
            'body' => [
                'mappings' => [
                    'properties' => $this->generateIndexStruct(),
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

    /**
     * @return array
     */
    private function generateIndexStruct(): array
    {
        $result = [];
        foreach ($_ENV['SCHEMA'] as $field => $dataType) {
            if ($dataType == 'string') {
                $esType = 'text';
            }
            if ($dataType == 'integer') {
                $esType = 'integer';
            }
            $result[$field] = ['type' => $esType];
        }

        return $result;
    }
}
