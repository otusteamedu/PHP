<?php


namespace hw16\models;

/**
 * Class YoutubeChannelBuilder
 * @package hw16\models
 *
 * @property string $name;
 * @property string $description;
 * @property int $subscribers;
 */
class YoutubeChannelBuilder
{
    private $name;
    private $description;
    private $subscribers;

    /**
     * @param string $name
     * @return YoutubeChannelBuilder
     */
    public function setName(string $name): YoutubeChannelBuilder
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $description
     * @return YoutubeChannelBuilder
     */
    public function setDescription(string $description): YoutubeChannelBuilder
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    public function setSubscribers(int $subscribers): YoutubeChannelBuilder
    {
        $this->subscribers = $subscribers;
        return $this;
    }

    /**
     * @return int
     */
    public function getSubscribers(): int
    {
        return $this->subscribers;
    }

    public function build(): YoutubeChannel
    {
        return new YoutubeChannel($this);
    }


}