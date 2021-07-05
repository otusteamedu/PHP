<?php


namespace App\Services\Youtube\Repositories\Traits;


use App\Models\Channel;

trait HasElasticsearchQueries
{
    /**
     * Возвращает строку запроса для вывода топ 10 каналов исходя из принципа
     * первым в выводе будет канал у которого сумма отношений лайков к дизлайкам по всем видео наилучшая
     * исчиляется по формуле СуммаВсехОтношений(ЛайкиОдногоВидео/ДизлайкиЭтогожеВидео).
     * Исли дизлайков для видео нет, то на ноль делить нельзя и количество дизлайков устанавливается как 1.
     *
     * @param Channel $channel
     * @param int $number
     * @return array
     */
    private function queryGetTopChannels(Channel $channel, int $number): array
    {
        return [
            'index' => $channel->getSearchIndex(),
            'type' => $channel->getSearchType(),
            'body' => [
                "size" => 0,
                'query' => [
                    'query_string' => [
                        'fields' => [
                            'channel_title^15',
                            'channel_description^14',
                            'description^13',
                            'youtube_video_id^12',
                            'published_at^11',
                            'title^10',
                            'tags',
                        ],
                        'query' => '*',
                        "analyze_wildcard" => true,
                        "allow_leading_wildcard" => true
                    ],
                ],
                'aggregations' => [
                    'top_channels' => [
                        'terms' => [
                            'field' => 'id',
                            "size" => $number,
                            "order" => ["ratio"=> "desc"],
                        ],
                        'aggregations' => [
                            'channel' => [
                                'top_hits' => [
                                    'size' => 1,
                                    '_source' => [
                                        'include' => [
                                            'channel_title',
                                            'channel_description',
                                            'description',
                                            'youtube_video_id',
                                            'published_at',
                                            'title',
                                            'tags',
                                        ]
                                    ]
                                ]
                            ],
                            'ratio' => [
                                'sum' => [
                                    'script' => [
                                        'lang' => 'painless',
                                        'inline' => "
                                        if (doc['like_count'].size() > 0 && doc['dislike_count'].size() > 0 && doc['dislike_count'].value !=0) {
                                            return doc['like_count'].value*1.0 / doc['dislike_count'].value*1.0
                                        } else if (doc['like_count'].size() > 0 && doc['dislike_count'].size() > 0 && doc['dislike_count'].value ==0) {
                                            return doc['like_count'].value*1.0
                                        }
                                        return false;",
                                    ],
                                ],
                            ],
                            'total_number_likes' => [
                                'sum' => [
                                    'field' => 'like_count'
                                ],
                            ],
                            'total_number_dislikes' => [
                                'sum' => [
                                    'field' => 'dislike_count'
                                ],
                            ],
                            'total_number_views' => [
                                'sum' => [
                                    'field' => 'view_count'
                                ],
                            ],
                            'total_number_comments' => [
                                'sum' => [
                                    'field' => 'comment_count'
                                ],
                            ],

                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * Возвращает строку запроса для статистики по каналу с id = $channelId
     *
     * @param Channel $channel
     * @param int $channelId
     * @return array
     */
    private function queryGetChannelStatistic(Channel $channel, int $channelId): array
    {
        return [
            'index' => $channel->getSearchIndex(),
            'type' => $channel->getSearchType(),
            'body' => [
                "size" => 0,
                'query' => [
                    'query_string' => [
                        'fields' => [
                            'id',
                        ],
                        'query' => $channelId,
                        "lenient" => true,
                        "analyze_wildcard" => true,
                        "allow_leading_wildcard" => true
                    ],
                ],
                'aggregations' => [
                    'top_channels' => [
                        'terms' => [
                            'field' => 'id',
                            "order" => ["total_number_likes"=> "desc"],
                        ],
                        'aggregations' => [
                            'channel' => [
                                'top_hits' => [
                                    'size' => 1,
                                    '_source' => [
                                        'include' => [
                                            'channel_title',
                                            'channel_description',
                                            'description',
                                            'youtube_video_id',
                                            'published_at',
                                            'title',
                                            'tags',
                                        ]
                                    ]
                                ]
                            ],
                            'total_number_likes' => [
                                'sum' => [
                                    'field' => 'like_count'
                                ],
                            ],
                            'total_number_dislikes' => [
                                'sum' => [
                                    'field' => 'dislike_count'
                                ],
                            ],
                            'total_number_views' => [
                                'sum' => [
                                    'field' => 'view_count'
                                ],
                            ],
                            'total_number_comments' => [
                                'sum' => [
                                    'field' => 'comment_count'
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * Возвращает строку запроса для поиска канала с id = $channelId
     *
     * @param Channel $channel
     * @param int $channelId
     * @return array
     */
    private function queryGetChannelById(Channel $channel, int $channelId): array
    {
        return [
            'index' => $channel->getSearchIndex(),
            'type' => $channel->getSearchType(),
            'body' => [
                'query' => [
                    'query_string' => [
                        'fields' => [
                            'id',
                        ],
                        'query' => $channelId,
                        "lenient" => true,
                        "analyze_wildcard" => true,
                        "allow_leading_wildcard" => true
                    ],
                ],
            ],
        ];
    }

    private function querySearchChannels(Channel $channel, string $query, int $limit, int $offset): array
    {
        return [
            'index' => $channel->getSearchIndex(),
            'type' => $channel->getSearchType(),
            'body' => [
                'query' => [
                    'query_string' => [
                        'fields' => [
                            'channel_title^15',
                            'channel_description^14',
                            'description^13',
                            'youtube_video_id^12',
                            'published_at^11',
                            'title^10',
                            'tags',
                        ],
                        'query' => $query . '*',
                        "analyze_wildcard" => true,
                        "allow_leading_wildcard" => true
                    ],
                ],
                'aggregations' => [
                    'channel' => [
                        'terms' => [
                            'field' => 'id',
                        ],

                        'aggs' => [
                            'total_number_likes' => [
                                'stats' => [
                                    'field' => 'like_count'
                                ],
                            ],
                            'total_number_dislikes' => [
                                'sum' => [
                                    'field' => 'dislike_count'
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'size' => $limit,
            'from' => $offset,
        ];
    }

    /**
     *  Возвращает все данные по каналам из Индекса
     * @param Channel $channel
     * @return array
     */
    private function queryGetAllChannels(Channel $channel): array
    {
        return [
            'index' => $channel->getSearchIndex(),
            'type' => $channel->getSearchType(),
            'body' => [
                'query' => [
                    'query_string' => [
                        'fields' => [
                            'channel_title',
                        ],
                        'query' => '*',
                        "analyze_wildcard" => true,
                        "allow_leading_wildcard" => true
                    ],
                ],
            ],
        ];
    }

}
