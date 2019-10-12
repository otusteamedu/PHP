<?php
declare(strict_types=1);

/**
 * @author Bazarov Aleksandr <bazarov@tutu.ru>
 *
 */

namespace APP\YouTubeInfo;

class YouTubeVideoInfo
{
    private $title;
    private $likesCount;
    private $dislikeCount;

    public function __construct(string $title, int $likesCount, int $dislikeCount)
    {
        $this->title = $title;
        $this->likesCount = $likesCount;
        $this->dislikeCount = $dislikeCount;
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
    public function getDislikeCount(): int
    {
        return $this->dislikeCount;
    }

    /**
     * @return int
     */
    public function getLikesCount(): int
    {
        return $this->likesCount;
    }
}