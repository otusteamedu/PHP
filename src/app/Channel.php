<?php

declare(strict_types=1);

namespace app;

use app\Video\Collection as VideoCollection;

class Channel
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var Collection
     */
    private $videoCollection;

    public function __construct(string $id = null, string $title = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->videoCollection = new VideoCollection();
    }

    public function setVideoCollection(VideoCollection $collection): void
    {
        $this->videoCollection = $collection;
    }

    public function addVideo(Video $video): void
    {
        $this->videoCollection->addVideo($video);
    }

    public function getVideoCollection(): VideoCollection
    {
        return $this->videoCollection;
    }

    /**
     * @return string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function toArray(): array
    {
        $videos = [];

        foreach ($this->videoCollection->getVideos() as $video) {
            /**
             * @var Video $video
             */
            $videos[] = $video->toArray();
        }
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'videos' => $videos
        ];
    }
}
