<?php

namespace App\Repositories;

use App\Models\Channel;

class ElasticChannelRepository extends AbstractElasticRepository
{
    /**
     * @param string $id
     *
     * @return array
     */
    public function findById(string $id): array
    {
        $params = [
            'index' => Channel::getIndexStatic(),
            'id' => $id
        ];

        return $this->client->get($params);
    }

    /**
     * @param Channel $channel
     *
     * @return array
     */
    public function fetchChannelStatistics(Channel $channel): array
    {
        return $this->client->search([
            'index' => 'videos',
            'body' => [
                'query' => [
                    'match' => [
                        'channelId' => $channel->getId()
                    ],
                ],
                'aggs' => [
                    "statistics" => [
                        "terms" => [
                            "field" => "channelId",
                        ],
                        "aggs" => [
                            "likes" => [
                                "sum" => [
                                    "field" => "likeCount"
                                ]
                            ],
                            'dislikes' => [
                                'sum' => [
                                    "field" => "dislikeCount"
                                ]
                            ],
                            "likeByDislikeQuotient" => [
                                "bucket_script" => [
                                    "buckets_path" => [
                                        "sLikes" => "likes",
                                        "sDislikes" => "dislikes"
                                    ],
                                    "script" => "if (params.sDislikes > 0) {
                                                    params.sLikes / params.sDislikes
                                                } else {
                                                    params.sLikes
                                                }"
                                ]
                            ]
                        ]
                    ]
                ],
                'size' => 0
            ],
        ]);
    }

    /**
     * @param int $quantity
     *
     * @return array
     */
    public function fetchTopChannels(int $quantity = 10): array
    {
        $params = [
            'index' => Channel::getIndexStatic(),
            'sort' => ['likesAndDislikesRatio:desc'],
            'size' => $quantity
        ];

        return $this->client->search($params);
    }
}
