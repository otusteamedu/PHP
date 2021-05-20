<?php

/**
 * Class ElasticSearchRepository working with elasticsearch storage
 */
class ElasticSearchRepository implements RepositoryInterface
{
    protected Client $client;

    public function __construct()
    {
        $elasticSearchClient = ClientBuilder::create();
        $elasticSearchClient->setHosts([$_ENV['ELASTICSEARCH_HOST']]);
        $this->client = $elasticSearchClient->build();
    }

    /**
     * @param $dto
     * @param $indexName
     *
     * @return bool
     * @throws \Exception
     */
    public function save($dto, $indexName): bool
    {
        $params = [
            'index' => $indexName,
            'body' => [],
        ];

        $properties = $this->getProperties($indexName);

        foreach ($properties as $property) {
            if (isset($dto->{$property})) {
                $params['body'][$property] = $dto->{$property};
            }
        }
        $result = $this->client->index($params);
        return isset($result['result']) && in_array($result['result'], ['updated', 'created'], true);
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getAllChannels(): array
    {
        $result = [];

        $elasticSearchRepository = new self();
        $hits = $elasticSearchRepository->getHits(Channel::TABLE_NAME);

        foreach ($hits as $channel) {
            $result[] = new ChannelDTO(
                $channel['id'],
                $channel['title'] ?? '',
                $channel['description'] ?? '',
                $channel['thumbnail'] ?? ''
            );
        }

        return $result;
    }

    /**
     * This method get most viewed channels from index
     *
     * @param string $indexName
     *
     * @return array
     * @throws \Exception
     */
    public function getHits(string $indexName): array
    {
        $params = [
            'index' => $indexName,
        ];

        $response = $this->client->search($params);

        $properties = $this->getProperties($indexName);

        $hits = $response['hits']['hits'] ?? [];

        $result = [];

        foreach ($hits as $row) {
            $item = [];
            foreach ($row['_source'] as $field => $value) {
                if (in_array($field, $properties, true)) {
                    $item[$field] = $value;
                }
            }

            $result[] = $item;
        }
        return $result;
    }

    /**
     * @param $indexName
     *
     * @return array
     * @throws \Exception
     */
    private function getProperties($indexName): array
    {
        $structureReader = new ElasticSearchStructureReader($indexName);
        return $structureReader->getPropertiesList();
    }

    /**
     * @param $channelId
     *
     * This method calculate stats for likes, dislikes, views, comments
     *
     * @return array
     */
    public function getCalculatedStatistics($channelId): array
    {
        $params = [
            'index' => Video::TABLE_NAME,
            'body' => [
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
        $statsData = $response['aggregations'] ?? [];

        return [
            'channelId' => $channelId ?? '',
            'likeSum' => $statsData['likeSum']['value'] ?? 0,
            'dislikeSum' => $statsData['dislikeSum']['value'] ?? 0,
            'viewSum' => $statsData['viewSum']['value'] ?? 0,
            'commentSum' => $statsData['commentSum']['value'] ?? 0,
        ];
    }

    /**
     * @throws \Exception
     */
    public function dropIndex(): void
    {
        $indexNames = [Channel::TABLE_NAME, Video::TABLE_NAME];
        foreach ($indexNames as $indexName) {
            $response = $this->client->indices()->delete(['index' => $indexName]);
        }

        if (!$response['acknowledged']) {
            Responser::responseFail('Indexes is not deleted');
        }
        Responser::responseOk();
    }
}