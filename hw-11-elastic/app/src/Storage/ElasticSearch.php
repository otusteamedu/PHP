<?php

namespace Storage;

use Config\Config;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Exception;
use Models\Channel;
use Models\ChannelDTO;
use Models\DTO;
use Models\Video;
use Structures\ElasticStructureReader;

class ElasticSearch extends NoSQLStorage
{
    public const STORAGE_NAME = 'elasticsearch';

    public const RESULT_UPDATED = 'updated';
    public const RESULT_CREATED = 'created';

    public const SUCCESS_RESULTS = [
        self::RESULT_CREATED,
        self::RESULT_UPDATED,
    ];

    protected $client;

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
                echo 'creating index ' . $indexName . PHP_EOL;
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

        try {
            $response = $this->client->indices()->getSettings($params);
        }
        catch (Exception $e) {
            return false;
        }

        return !isset($response['error']);
    }

    private function createIndex(string $indexName): bool
    {
        $structure = new ElasticStructureReader($indexName);

        $result = $this->client->indices()->create($structure->getStructure());

        return !empty($result['acknowledged']);
    }

    public function store (DTO $dto, string $indexName): bool
    {
        $params = [
            'index' => $indexName,
            'body'  => [],
        ];

        $dataArray = $dto->asArray();

        foreach ($dataArray as $key => $value) {
            if ($key === 'id') {
                $params[$key] = $value;
            }
            else {
                $params['body'][$key] = $value;
            }
        }

        $result = $this->client->index($params);

        if (isset($result['result']) && in_array($result['result'], self::SUCCESS_RESULTS)) {
            return true;
        }

        return false;
    }

    public function delete (string $id, string $indexName): bool
    {
        $params = [
            'index' => $indexName,
            'id'    => $id,
        ];

        $response = $this->client->delete($params);

        if (isset($response['result']) && $response['result'] === 'deleted') {
            return true;
        }

        return false;
    }

    public function dropIndex (string $indexName): bool
    {
        $params = [
            'index' => $indexName,
        ];

        $response = $this->client->indices()->delete($params);

        return !empty($response['acknowledged']);
    }

    public function getAll(string $indexName): array
    {
        $params = [
            'index' => $indexName,
        ];

        $response = $this->client->search($params);

        $structureReader = new ElasticStructureReader($indexName);
        $properties      = $structureReader->getPropertiesList();

        $hits = $response['hits']['hits'] ?? [];

        $result = [];

        foreach ($hits as $row) {
            $item = [];

            $item['id'] = $row['_id'];

            foreach ($row['_source'] as $field => $value) {
                if (in_array($field, $properties)) {
                    $item[$field] = $value;
                }
            }

            $result[] = $item;
        }

        return $result;
    }

    public function calculateStats (string $channelId): array
    {
        $params = [
            'index' => Video::TABLE_NAME,
            'body'  => [
                'query' => [
                    'match' => [
                        'channelId' => $channelId,
                    ]
                ],
                'aggs' => [
                    'likeSum' => [
                        'sum' => [
                            'field' => 'likeCount',
                        ],
                    ],
                    'dislikeSum' => [
                        'sum' => [
                            'field' => 'dislikeCount',
                        ],
                    ],
                    'viewSum' => [
                        'sum' => [
                            'field' => 'viewCount',
                        ],
                    ],
                    'commentSum' => [
                        'sum' => [
                            'field' => 'commentCount',
                        ],
                    ],
                ],
            ],
        ];

        $response = $this->client->search($params);

        $rawStats = $response['aggregations'] ?? [];

        return [
            'channelId'  => $channelId ?? '',
            'likeSum'    => $rawStats['likeSum']['value'] ?? 0,
            'dislikeSum' => $rawStats['dislikeSum']['value'] ?? 0,
            'viewSum'    => $rawStats['viewSum']['value'] ?? 0,
            'commentSum' => $rawStats['commentSum']['value'] ?? 0,
        ];
    }
}