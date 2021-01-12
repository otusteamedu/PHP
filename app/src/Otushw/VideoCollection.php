<?php


namespace Otushw;

class VideoCollection implements \Iterator
{

    private int $pointer = 0;
    private int $total = 0;
    private array $objects = [];
    private array $raw = [];

    public function __construct(array $raw = [])
    {
        if (!empty($raw)) {
            $this->raw = $raw;
            $this->total = count($raw);
        }
    }

    public function add(Video $video)
    {
        $this->objects[$this->total] = $video;
        $this->total++;
    }

    /**
     * @param int $num
     *
     * @return null|Video
     */
    private function getRow(int $num): ?Video
    {
        if ($num >= $this->total || $num < 0) {
            return null;
        }

        if (isset($this->objects[$num])) {
            return $this->objects[$num];
        }

        if (isset($this->raw[$num])) {
            $this->objects[$num] = $this->createVideoObject($this->raw[$num]);
            return $this->objects[$num];
        }

        return null;
    }

    /**
     * @param array $source
     *
     * @return Video
     */
    private function createVideoObject(array $source): Video
    {
        return new Video(
            $source['id'],
            $source['title'],
            $source['viewCount'],
            $source['likeCount'],
            $source['disLikeCount'],
            $source['commentCount']
        );
    }

    /**
     * @return Video
     */
    public function current(): ?Video
    {
        return $this->getRow($this->pointer);
    }

    /**
     * @return Video
     */
    public function next(): ?Video
    {
        $this->pointer++;
        return $this->current();
    }

    /**
     * @return int
     */
    public function key(): int
    {
        return $this->pointer;
    }

    /**
     * @return bool
     */
    public function valid(): bool
    {
        return (!is_null($this->current()));
    }

    public function rewind()
    {
        $this->pointer = 0;
    }
}
