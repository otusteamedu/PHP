<?php

namespace App\ModelHydrators;

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
}
