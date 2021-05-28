<?php

namespace App\ModelHydrators;

use App\Models\Channel;

class YoutubeChannelModelHydrator extends AbstractYoutubeHydrator
{
    protected const MAPPING = [
        'setId' => 'id',
        'setTitle' => 'snippet.title',
        'setDescription' => 'snippet.description',
        'setPublishedAt' => 'snippet.publishedAt',
        'setViewCount' => 'statistics.viewCount',
        'setSubscriberCount' => 'statistics.subscriberCount',
        'setVideoCount' => 'statistics.videoCount'
    ];

    protected const MODEL = 'App\\Models\\Channel';

    /**
     * @var Channel
     */
    public Channel $model;

    /**
     * YoutubeChannelModelHydrator constructor.
     *
     * @param Channel $model
     */
    public function __construct(Channel $model)
    {
        $this->model = $model;
    }
}
