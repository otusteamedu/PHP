<?php
namespace Otus\HW11\Task1;

use \Otus\HW11\Task1;

class Channel
{
    protected $name;
    protected $url;
    protected $subscribers;
    protected $videos;

    public function __construct(array $arChannel)
    {
        if (
            is_null($arChannel['name'])
            || is_null($arChannel['url'])
            || is_null($arChannel['subscribers'])
        ) {
            throw new \InvalidArgumentException('Channel type expect name, url, subscribers');
        }

        $this->name = (string) $arChannel['name'];
        $this->url = (string) $arChannel['url'];
        $this->subscribers = (int) $arChannel['subscribers'];

        $this->videos = new \DS\Vector();
        if ( is_array($arChannel['videos']) ) {
            foreach ($arChannel['videos'] as $video) {
                if (is_array($video)) {
                    $this->videos->push(new Task1\Video(
                        [
                            'name' => $video['name'],
                            'url' => $video['url'],
                            'likes' => $video['likes'],
                            'dislikes' => $video['dislikes'],
                        ]
                    ));
                } elseif ($video instanceof \stdClass) {
                    $this->videos->push(new Task1\Video(
                        [
                            'name' => $video->name,
                            'url' => $video->url,
                            'likes' => $video->likes,
                            'dislikes' => $video->dislikes
                        ]
                    ));
                }
            }
        }
    }

    /**
     * @return \DS\Vector
     */
    public function getVideos(): \DS\Vector
    {
        return $this->videos;
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
    public function getSubscribers(): int
    {
        return $this->subscribers;
    }
}