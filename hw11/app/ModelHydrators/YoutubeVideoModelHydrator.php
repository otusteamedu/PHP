<?php

namespace App\ModelHydrators;

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
}
