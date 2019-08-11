<?php


namespace hw16\models;

/**
 * Class YoutubeChannel
 * @package hw16\models
 *
 * @property string $name;
 * @property string $description;
 * @property int $subscribers;
 */
class YoutubeChannel
{
    private $name;
    private $description;
    private $subscribers;

    /**
     * YoutubeChannel constructor.
     * @param YoutubeChannelBuilder $youtubeChannelBuilder
     */
    public function __construct(YoutubeChannelBuilder $youtubeChannelBuilder)
    {
        $this->name = $youtubeChannelBuilder->name;
        $this->description = $youtubeChannelBuilder->description;
        $this->subscribers = $youtubeChannelBuilder->subscribers;
    }
}