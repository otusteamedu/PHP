<?php

namespace app;

class Stats
{
    /**
     * @var int
     */
    public $likes = 0;

    /**
     * @var int
     */
    public $dislikes = 0;

    /**
     * @var int
     */
    public $commentsCount = 0;

    /**
     * @var int
     */
    public $views = 0;

    public function __construct(int $likes = 0, int $dislikes = 0, $commentsCount = 0, $views = 0)
    {
        $this->likes = $likes;
        $this->dislikes = $dislikes;
        $this->commentsCount = $commentsCount;
        $this->views = $views;
    }
}