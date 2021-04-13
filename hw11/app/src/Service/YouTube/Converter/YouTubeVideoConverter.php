<?php

declare(strict_types=1);

namespace App\Service\YouTube\Converter;

use App\Service\YouTube\Dto\VideoDto;
use Google_Service_YouTube_Video;

class YouTubeVideoConverter
{

    public function toDto(Google_Service_YouTube_Video $youTubeVideo): VideoDto
    {
        $videoDto = new VideoDto(
            $youTubeVideo->getId(),
            $youTubeVideo->getSnippet()->getTitle(),
            $youTubeVideo->getSnippet()->getChannelId()
        );

        $videoDto->likeCount = intval($youTubeVideo->getStatistics()->getLikeCount());
        $videoDto->dislikeCount = intval($youTubeVideo->getStatistics()->getDislikeCount());

        return $videoDto;
    }

}