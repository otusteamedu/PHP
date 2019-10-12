<?php
declare(strict_types=1);

/**
 * @author Bazarov Aleksandr <bazarov@tutu.ru>
 *
 */

namespace APP\YouTubeInfo;

class YouTubeChannelInfo
{
    private $title;
    /** @var YouTubeVideoInfo[] */
    private $videosInfo;

    public function __construct(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return array
     */
    public function getVideos(): ?array
    {
        return $this->videosInfo;
    }

    public function addVideoInfo(YouTubeVideoInfo $videoInfo): void
    {
        $this->videosInfo[] = $videoInfo;
    }

    public function getByVideoInfo(): array
    {
        $channel["channelName"] = $this->title;
        foreach ($this->videosInfo as $videoInfo) {
            $video["title"] = $videoInfo->getTitle();
            $video["likes"] = $videoInfo->getLikesCount();
            $video["dislikes"] = $videoInfo->getDislikeCount();
            $channel["videos"][] = $video;
        }

        return $channel;
    }
}