<?php


namespace hw16\models;

/**
 * Class YoutubeVideoBuilder
 * @package hw16\models
 *
 * @property string $channel;
 * @property string $name;
 * @property int $views;
 * @property int $likes;
 * @property int $dislikes;
 */
class YoutubeVideoBuilder
{
    private $channel;
    private $name;
    private $views;
    private $likes;
    private $dislikes;

    /**
     * @param string $channel
     * @return YoutubeVideoBuilder
     */
    public function setChannel(string $channel): YoutubeVideoBuilder
    {
        $this->channel = $channel;
        return $this;
    }

    /**
     * @return int
     */
    public function getChannel(): int
    {
        return $this->channel;
    }

    /**
     * @param string $name
     * @return YoutubeVideoBuilder
     */
    public function setName(string $name): YoutubeVideoBuilder
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
     * @param string $views
     * @return YoutubeVideoBuilder
     */
    public function setViews(string $views): YoutubeVideoBuilder
    {
        $this->views = $views;
        return $this;
    }

    /**
     * @return int
     */
    public function getViews(): int
    {
        return $this->views;
    }

    /**
     * @param string $likes
     * @return YoutubeVideoBuilder
     */
    public function setLikes(string $likes): YoutubeVideoBuilder
    {
        $this->likes = $likes;
        return $this;
    }

    /**
     * @return int
     */
    public function getLikes(): int
    {
        return $this->likes;
    }

    /**
     * @param string $dislikes
     * @return YoutubeVideoBuilder
     */
    public function setDislikes(string $dislikes): YoutubeVideoBuilder
    {
        $this->dislikes = $dislikes;
        return $this;
    }

    /**
     * @return int
     */
    public function getDislikes(): int
    {
        return $this->dislikes;
    }

    /**
     * @return YoutubeVideo
     */
    public function build(): YoutubeVideo
    {
        return new YoutubeVideo($this);
    }
}