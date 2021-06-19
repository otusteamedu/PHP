<?php

namespace App\Model\Storage;

use App\Api\ConfigInterface;
use App\Model\Youtube\Channel;
use App\Model\Youtube\Video;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;

class YoutubeElasticSearch implements NoSqlStorageInterface, YoutubeStorageInterface
{
    private Client $client;

    public function __construct(ConfigInterface $config)
    {
        $this->client = ClientBuilder::create()
            ->setHosts($config->getOrFail('elasticsearch.hosts'))
            ->build();
    }

    public function initIndexes(): ?array
    {
        $indices = $this->client->indices();
        $result = [];
//        $indices->delete(['index' => 'channel',]);
//        $indices->delete(['index' => 'video',]);
        if (!$indices->exists(['index' => 'channel',])) {
            $result[] = $indices->create([
                 'index' => 'channel',
                 'body' => [
                     'mappings' => [
                         'properties' => [
                             'id' => ['type' => 'keyword'],
                             'title' => ['type' => 'keyword'],
                             'description' => ['type' => 'text'],
                         ],
                     ],
                 ],
             ]);
        }
        if (!$indices->exists(['index' => 'video',])) {
            $result[] = $indices->create([
                 'index' => 'video',
                 'body' => [
                     'mappings' => [
                         'properties' => [
                             'id' => ['type' => 'keyword'],
                             'channelId' => ['type' => 'keyword'],
                             'title' => ['type' => 'keyword'],
                             'likeCount' => ['type' => 'integer'],
                             'dislikeCount' => ['type' => 'integer'],
                         ]
                     ],
                 ],
             ]);
        }
        return $result;
    }

    public function channelSummary(string $channelId): array
    {
        return $this->client->search([
            'index' => 'video',
            'body'  => [
                'query' => [
                    'match' => [
                        'channelId' => $channelId
                    ],
                ],
                'aggs' => [
                    'likes_total' => [
                        'sum' => ['field' => 'likeCount']
                    ],
                ],
            ],
        ]);
    }

    public function topChannels(int $number): array
    {
        $result = $this->client->search([
            'index' => 'video',
            'body'  => [
                'size' => 0,
                'aggs' => [
                    'by_channel' => [
                        'terms' => [
                            'field' => 'channelId',
                        ],
                        'aggs' => [
                            'likes_total' => [
                                'sum' => ['field' => 'likeCount']
                            ],
                            'dislikes_total' => [
                                'sum' => ['field' => 'dislikeCount']
                            ],
                            'ratio' => [
                                'bucket_script' => [
                                    'buckets_path' => [
                                        'likes' => 'likes_total',
                                        'dislikes' => 'dislikes_total',
                                    ],
                                    'script' => 'params.likes / params.dislikes',
                                ],
                            ],
                            'ratio_sort' => [
                                'bucket_sort' => [
                                    'sort' => [
                                        ['ratio' => ['order' => 'desc']],
                                    ]
                                ]
                            ],
                        ],
                    ],
                ]
            ]
        ]);
        $data = [];
        $buckets = array_slice($result['aggregations']['by_channel']['buckets'] ?? [], 0, $number);
        foreach ($buckets as $bucket) {
            $channelId = $bucket['key'];
            $title = $this->getChannel($channelId)['title'] ?? null;
            $data[] = ['channelId' => $channelId, 'title' => $title, 'ratio' => $bucket['ratio']['value'] ?? null];
        }
        return $data;
    }

    public function addChannel(Channel $channel): array
    {
        return $this->client->index([
            'index' => 'channel',
            'id'    => $channel->getId(),
            'body'  => $channel->getData(),
        ]);
    }

    public function addVideo(Video $video): array
    {
        return $this->client->index([
            'index' => 'video',
            'id'    => $video->getId(),
            'body'  => $video->getData(),
        ]);
    }


    public function removeChannel(string $channelId): array
    {
        $this->client->deleteByQuery([
            'index' => 'video',
            'body'  => [
                'query' => [
                    'match' => [
                        'channelId' => $channelId
                    ],
                ],
            ],
        ]);
        return $this->client->delete([
            'index' => 'channel',
            'id'    => $channelId,
        ]);
    }

    public function removeVideo(string $videoId): array
    {
        return $this->client->delete([
            'index' => 'video',
            'id'    => $videoId,
        ]);
    }

    public function getChannel(string $channelId): ?array
    {
        $data = $this->client->search([
            'index' => 'channel',
            'body'  => [
                'query' => [
                    'match' => [
                        'id' => $channelId
                    ],
                ],
            ],
        ]);
        return $data['hits']['hits'][0]['_source'] ?? null;
    }
}
