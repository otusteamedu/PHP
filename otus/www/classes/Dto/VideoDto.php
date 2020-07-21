<?php

namespace Classes\Dto;

/**
 * @property string $videoName
 * @property string $videoId
 * @property string $chanelId
 * @property integer $videoLikeCount
 * @property integer videoDislikeCount
 */

class VideoDto
{
    public $videoName;
    public $videoId;
    public $chanelId;
    public $videoLikeCount;
    public $videoDislikeCount;

    public static function build(VideoDtoBuilder $builder)
    {
        $self = new self();
        $self->videoName = $builder->getVideoName();
        $self->videoId = $builder->getVideoId();
        $self->chanelId = $builder->getChannelId();
        $self->videoLikeCount = $builder->getVideoLikeCount();
        $self->videoDislikeCount = $builder->getVideoDislikeCount();

        return $self;
    }

}
