<?php

declare(strict_types=1);

namespace App\ReadModel\Channel;

use Elasticsearch\Client;

class ChannelStatsFetcher
{

    private const CHANNELS_INDEX_NAME = 'channels';
    private const VIDEOS_INDEX_NAME   = 'videos';
    private Client $elasticsearchClient;

    public function __construct(Client $elasticsearchClient)
    {
        $this->elasticsearchClient = $elasticsearchClient;
    }

    public function getLikeCountByChannel(string $channelId): int
    {
        $match = [
            'channelId' => $channelId,
        ];

        return intval($this->getSum(self::VIDEOS_INDEX_NAME, 'likeCount', $match));
    }

    public function getDislikeCountByChannel(string $channelId): int
    {
        $match = [
            'channelId' => $channelId,
        ];

        return intval($this->getSum(self::VIDEOS_INDEX_NAME, 'dislikeCount', $match));
    }

    private function getSum(string $indexName, string $fieldName, array $match): float
    {
        $params = [
            'index' => $indexName,
            'body'  => [
                'query' => [
                    'match' => $match,
                ],
                'size'  => 0,
                'aggs'  => [
                    $fieldName => [
                        'sum' => [
                            'field' => $fieldName,
                        ],
                    ],
                ],
            ],
        ];

        $response = $this->elasticsearchClient->search($params);

        return $response['aggregations'][$fieldName]['value'];
    }

    public function getBestChannels(int $numberOfChannels): array
    {
        $params = [
            'index' => self::VIDEOS_INDEX_NAME,
            'body'  => [
                'runtime_mappings' => [
                    "video.ratioOfLikesAndDislikes" => [
                        "type"   => "double",
                        "script" => "
                           emit(doc['dislikeCount'].value == 0 ? doc['likeCount'].value : doc['likeCount'].value/doc['dislikeCount'].value);
                        ",
                    ],
                ],
                'size'             => 0,
                'aggs'             => [
                    'groupByChannelId' => [
                        'terms' => [
                            'field' => 'channelId',
                        ],
                        'aggs'  => [
                            'ratioOfLikesAndDislikes' => [
                                'sum' => [
                                    'field' => 'video.ratioOfLikesAndDislikes',
                                ],
                            ],
                            'ratioBucketSort'         => [
                                'bucket_sort' => [
                                    'sort' => [
                                        'ratioOfLikesAndDislikes' => ['order' => 'desc'],
                                    ],
                                    'size' => $numberOfChannels,
                                ],
                            ],
                        ],
                    ],
                ],

            ],
        ];

        $response = $this->elasticsearchClient->search($params);

        $channelIds = $this->extractKeysFromBuckets($response['aggregations']['groupByChannelId']['buckets']);
        $channelNames = $this->getChannelNames($channelIds);

        return array_map(
            fn($channelId) => (!empty($channelNames[$channelId]) ? $channelNames[$channelId] : 'Название канала не найдено'),
            $channelIds
        );
    }

    private function extractKeysFromBuckets(array $buckets): array
    {
        return array_map(fn($bucket) => $bucket['key'], $buckets);
    }

    private function getChannelNames(array $channelIds): array
    {
        $fieldNames = [
            'id',
            'title',
        ];

        $data = $this->selectByIds(self::CHANNELS_INDEX_NAME, $fieldNames, $channelIds);

        return array_combine(array_column($data, 'id'), array_column($data, 'title'));
    }

    private function selectByIds(string $indexName, array $fieldNames, array $ids): array
    {
        $params = [
            'index' => $indexName,
            'body'  => [
                'query'   => [
                    'ids' => [
                        'type'   => '_doc',
                        'values' => $ids,
                    ],
                ],
                'fields'  => $fieldNames,
                '_source' => false,
            ],
        ];

        $response = $this->elasticsearchClient->search($params);

        $result = [];
        foreach ($response['hits']['hits'] as $hit) {
            $result[] = array_map(fn($fieldValue) => implode('', $fieldValue), $hit['fields']);
        }

        return $result;
    }

}