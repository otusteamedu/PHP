<?php

declare(strict_types=1);

namespace App\Entities;

use ArrayAccess;
use Countable;
use Iterator;

class VideoCollection implements Iterator, ArrayAccess, Countable
{
    /** @var int */
    protected $position = 0;
    /**
     * @var YouTubeVideo[]
     */
    protected $videos = [];

    /**
     * @param YouTubeVideo[] $videos
     */
    public function __construct(array $videos = [])
    {
        $this->position = 0;
        $this->addVideos($videos);
    }

    /**
     * @param YouTubeVideo $video
     * @return VideoCollection
     */
    public function addVideo(YouTubeVideo $video): VideoCollection
    {
        if ($this->getVideoById($video->getId())) {
            throw new \InvalidArgumentException('Video already added.');
        }

        $this->videos[$video->getId()] = $video;

        return $this;
    }

    /**
     * @param array $videos
     */
    public function addVideos(array $videos): void
    {
        foreach ($videos as $video) {
            if ($video instanceof YouTubeVideo) {
                $this->addVideo($video);
            }
        }
    }

    /**
     * @return YouTubeVideo[]
     */
    public function getVideos(): array
    {
        return $this->videos;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->videos);
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    /**
     * @return bool
     */
    public function isNotEmpty(): bool
    {
        return $this->count() > 0;
    }

    /**
     * @param string $id
     * @return YouTubeVideo|null
     */
    public function getVideoById(string $id): ?YouTubeVideo
    {
        if (array_key_exists($id, $this->videos)) {
            return $this->videos[$id];
        }

        return null;
    }

    /**
     * @param string $id
     */
    public function deleteVideo(string $id): void
    {
        if (array_key_exists($id, $this->videos)) {
            unset($this->videos[$id]);
        }
    }

    /**
     * @param string $field
     * @return array
     */
    public function pluck(string $field): array
    {
        $result = array_map(function (YouTubeVideo $video) use ($field) {
            $data = $video->toArray();
            if (array_key_exists($field, $data)) {
                return $data[$field];
            }
            return null;
        }, $this->videos);

        return array_filter($result);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return array_map(function (YouTubeVideo $video) {
            return $video->toArray();
        }, $this->videos);
    }

    /**
     * @return YouTubeVideo
     */
    public function current(): YouTubeVideo
    {
        return $this->videos[$this->position];
    }

    /**
     * @inheritDoc
     */
    public function next(): void
    {
        ++$this->position;
    }

    /**
     * @inheritDoc
     */
    public function key(): int
    {
        return $this->position;
    }

    /**
     * @inheritDoc
     */
    public function valid(): bool
    {
        return isset($this->videos[$this->position]);
    }

    /**
     * @inheritDoc
     */
    public function rewind(): void
    {
        $this->position = 0;
    }

    /**
     * @inheritDoc
     */
    public function offsetExists($offset): bool
    {
        return isset($this->videos[$offset]);
    }

    /**
     * @param mixed $offset
     * @return YouTubeVideo
     */
    public function offsetGet($offset): YouTubeVideo
    {
        return $this->videos[$offset];
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value)
    {
        if ($value instanceof YouTubeVideo) {
            $this->videos[$offset] = $value;
        } else {
            throw new \InvalidArgumentException('Value must be an instance of the YouTubeVideo class.');
        }
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset): void
    {
        unset($this->videos[$offset]);
    }
}
