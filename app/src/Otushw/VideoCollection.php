<?php


namespace Otushw;

use Exception;

class VideoCollection implements \Iterator
{

    private $pointer = 0;
    private $total = 0;
    private $result;
    private $objects = [];
    private $raw = [];

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

//    public function delete($num)
//    {
//        if (!isset($this->objects[$num])) {
//            throw new Exception('Cannot be deleted, the requested number does not exist in the collection.');
//        }
//
//        unset($this->objects[$num]);
//        $this->total = count($this->objects);
//    }

    private function getRow($num)
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

    private function createVideoObject($source)
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

    public function current()
    {
        return $this->getRow($this->pointer);
    }

    public function next()
    {
        $this->pointer++;
        return $this->current();
    }

    public function key()
    {
        return $this->pointer;
    }

    public function valid()
    {
        return (!is_null($this->current()));
    }

    public function rewind()
    {
        $this->pointer = 0;
    }
}
