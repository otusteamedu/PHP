<?php

namespace App\ModelHydrators;

class ElasticChannelModelHydrator extends AbstractElasticHydrator
{
    protected const MAPPING = [
        'setId' => 'id',
        'setTitle' => 'title',
        'setDescription' => 'description',
        'setPublishedAt' => 'publishedAt',
        'setViewCount' => 'viewCount',
        'setSubscriberCount' => 'subscriberCount',
        'setVideoCount' => 'videoCount',
        'setVideoIds' => 'videoIds',
        'setLikesNumber' => 'likes',
        'setDislikesNumber' => 'dislikes',
        'getLikesAndDislikesRatio' => 'likesAndDislikesRatio',
    ];

    protected const MODEL = 'App\\Models\\Channel';
}
