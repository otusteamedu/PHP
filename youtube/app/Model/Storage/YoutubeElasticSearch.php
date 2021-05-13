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
        return $this->client->search([
            'index' => 'video',
            'body'  => [
                'size' => 0,
                'aggs' => [
                    'by_channel' => [
                        'terms' => [
                            'field' => 'channelId',
                            'order' => ['likes_total' => 'desc'],
                            'size' => 3,
                        ],
                        'aggs' => [
                            'likes_total' => [
                                'sum' => ['field' => 'likeCount']
                            ],
                        ],
                    ],
                ]
            ]
        ]);
    }

    public function addChannel(Channel $channel): array
    {
        $response = $this->client->index([
            'index' => 'channel',
            'id'    => $channel->getId(),
            'body'  => $channel->getData(),
        ]);
        return $response;
    }

    public function addVideo(Video $video): array
    {
        $response = $this->client->index([
            'index' => 'video',
            'id'    => $video->getId(),
            'body'  => $video->getData(),
        ]);
        return $response;
    }
}
