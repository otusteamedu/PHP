<?php

namespace App\ModelHydrators;

class YoutubeSearchModelHydrator extends AbstractYoutubeHydrator
{
    protected const MAPPING = [
        'setId' => 'id.videoId'
    ];

    protected const MODEL = 'App\\Models\\Search';
}
