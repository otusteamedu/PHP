<?php

namespace crazydope\youtube;

class ChannelStat implements ChannelStatInterface
{
    protected $title = '';

    protected $likes = 0;

    protected $dislikes = 0;

    protected $rate = 0;

    /**
     * ChannelStat constructor.
     * @param string $title
     * @param int $likes
     * @param int $dislikes
     * @param int $rate
     */
    public function __construct(string $title, int $likes, int $dislikes, $rate = 0)
    {
        $this->title = $title;
        $this->likes = $likes;
        $this->dislikes = $dislikes;
        $this->rate = $rate;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return int
     */
    public function getLikes(): int
    {
        return $this->likes;
    }

    /**
     * @return int
     */
    public function getDislikes(): int
    {
        return $this->dislikes;
    }

    /**
     * @return int
     */
    public function getRate(): int
    {
        return $this->rate;
    }

    public function __toString(): string
    {
        return 'Channel "'.$this->title.'" rate '. $this->rate. ' ('.$this->likes.'/'.$this->dislikes.')';
    }
}