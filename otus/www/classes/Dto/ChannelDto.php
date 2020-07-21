<?php

namespace Classes\Dto;

/**
 * @property string $channelId
 * @property string $channelName
 * @property string $channelVideoIds
 */

class ChannelDto
{
    private $channelId;
    private $channelName;
    private $channelVideoIds = [];

    public static function build(ChannelDtoBuilder $builder)
    {
        $self = new self();
        $self->channelId = $builder->getChannelId();
        $self->channelName = $builder->getChannelName();
        $self->channelVideoIds = $builder->getChannelVideosIds();

        return $self;
    }
}
