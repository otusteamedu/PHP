<?php

declare(strict_types=1);

namespace app\Video;

use app\Video;

class Collection
{
    /**
     * @var array
     */
    private $items = [];

    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    public function addVideo(Video $video): void
    {
        $this->items[$video->getId()] = $video;
    }

    public function addVideos(array $items = []): void
    {
        foreach ($items as $item) {
            if (!($item instanceof Video)) {
                throw new \InvalidArgumentException("Item must be instance of class app\Video");
            }
            $this->addVideo($item);
        }
    }

    public function getVideo(string $id): ?Video
    {
        return $this->items[$id] ?? null;
    }

    public function getVideos(): array
    {
        return $this->items;
    }
}