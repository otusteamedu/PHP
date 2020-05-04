<?php

namespace Ozycast\App\Relationship;

use Ozycast\App\App;
use Ozycast\App\DTO\Channel;
use Ozycast\App\Mappers\ChannelMapper;
use Ozycast\App\DTO\Video;

Class VideoRelationship
{
    /**
     * @param Video $video
     * @return \Ozycast\App\DTO\Channel|null
     */
    public static function channel(Video $video): Channel
    {
        $channel = (new ChannelMapper(App::$db))->findOne(['id' => $video->getChannelId()]);
        return $channel;
    }
}