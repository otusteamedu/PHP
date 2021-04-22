<?php

namespace App\ModelHydrators;

use App\Models\Video;

class YoutubeVideoModelHydrator extends AbstractYoutubeHydrator
{
    protected const MAPPING = [
        'setId' => 'id',
        'setDuration' => 'contentDetails.duration',
        'setViewCount' => 'statistics.viewCount',
        'setLikeCount' => 'statistics.likeCount',
        'setDislikeCount' => 'statistics.dislikeCount',
        'setFavoriteCount' => 'statistics.favoriteCount',
        'setCommentCount' => 'statistics.commentCount',
    ];

    protected const MODEL = 'App\\Models\\Video';

    /**
     * @var Video
     */
    public Video $model;

    /**
     * YoutubeVideoModelHydrator constructor.
     *
     * @param Video $model
     */
    public function __construct(Video $model)
    {
        $this->model = $model;
    }
}
