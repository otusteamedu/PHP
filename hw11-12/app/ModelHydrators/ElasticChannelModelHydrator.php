<?php

namespace App\ModelHydrators;

use App\Models\Channel;

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

    /**
     * @var Channel
     */
    public Channel $model;

    /**
     * ElasticChannelModelHydrator constructor.
     *
     * @param Channel $model
     */
    public function __construct(Channel $model)
    {
        $this->model = $model;
    }
}
