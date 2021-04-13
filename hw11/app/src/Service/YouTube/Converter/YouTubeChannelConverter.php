<?php

declare(strict_types=1);

namespace App\Service\YouTube\Converter;

use App\Service\YouTube\Dto\ChannelDto;
use Google_Service_YouTube_Channel;

class YouTubeChannelConverter
{

    public function toDto(Google_Service_YouTube_Channel $youTubeChanel): ChannelDto
    {
        return new ChannelDto(
            $youTubeChanel->getId(),
            $youTubeChanel->getSnippet()->getTitle()
        );

    }

}