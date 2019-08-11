<?php

namespace hw16\models;

/**
 * Class YoutubeVideo
 * @package hw16\models
 *
 * @property string $channel;
 * @property string $name;
 * @property int $views;
 * @property int $likes;
 * @property int $dislikes;
 */
class YoutubeVideo
{
    private $channel;
    private $name;
    private $views;
    private $likes;
    private $dislikes;

    /**
     * YoutubeVideo constructor.
     * @param YoutubeVideoBuilder $youtubeVideoBuilder
     */
    public function __construct(YoutubeVideoBuilder $youtubeVideoBuilder)
    {
        $this->channel = $youtubeVideoBuilder->getChannel();
        $this->name = $youtubeVideoBuilder->getName();
        $this->likes = $youtubeVideoBuilder->getLikes();
        $this->dislikes = $youtubeVideoBuilder->getDislikes();
        $this->views = $youtubeVideoBuilder->getViews();
    }
}