<?php

namespace App\ModelHydrators;

use App\Models\Search;

class YoutubeSearchModelHydrator extends AbstractYoutubeHydrator
{
    protected const MAPPING = [
        'setId' => 'id.videoId'
    ];

    protected const MODEL = 'App\\Models\\Search';

    /**
     * @var Search
     */
    public Search $model;

    /**
     * YoutubeSearchModelHydrator constructor.
     *
     * @param Search $model
     */
    public function __construct(Search $model)
    {
        $this->model = $model;
    }
}
