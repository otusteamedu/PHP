<?php
namespace Otus\HW11\Task1;

use \Otus\HW11\Task1;

class Video
{
    protected $name;
    protected $url;
    protected $likes;
    protected $dislikes;

    public function __construct(array $arVideo)
    {
        if (
            is_null($arVideo['name'])
            || is_null($arVideo['url'])
            || is_null($arVideo['likes'])
            || is_null($arVideo['dislikes'])
        ) {
            throw new \InvalidArgumentException('Video type expect name, url, likes, dislikes');
        }

        $this->name = (string) $arVideo['name'];
        $this->url = (string) $arVideo['url'];
        $this->likes = (int) $arVideo['likes'];
        $this->dislikes = (int) $arVideo['dislikes'];
    }

    /**
     * @return int
     */
    public function getDislikes(): int
    {
        return $this->dislikes;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return int
     */
    public function getLikes(): int
    {
        return $this->likes;
    }
}