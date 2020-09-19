<?php

namespace Model;

use Controllers\ElasticSearchController;

class YouTubeChannelModel
{
    /** @var string имя канала */
    protected $name;
    /** @var string общее число просмотров */
    protected $views;
    /** @var int всего загружено видео */
    protected $countVideo;

    public function save()
    {
        return (new ElasticSearchController())->addDocument([
            'index' => 'youtube',
            'id' => $this->name,
            'body' => ['views' => $this->views, 'countVideo' => $this->countVideo]
        ]);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return YouTubeChannelModel
     */
    public function setName(string $name): YouTubeChannelModel
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getViews(): string
    {
        return $this->views;
    }

    /**
     * @param string $views
     * @return YouTubeChannelModel
     */
    public function setViews(string $views): YouTubeChannelModel
    {
        $this->views = $views;
        return $this;
    }

    /**
     * @return int
     */
    public function getCountVideo(): int
    {
        return $this->countVideo;
    }

    /**
     * @param int $countVideo
     * @return YouTubeChannelModel
     */
    public function setCountVideo(int $countVideo): YouTubeChannelModel
    {
        $this->countVideo = $countVideo;
        return $this;
    }
}
