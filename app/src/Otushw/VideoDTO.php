<?php


namespace Otushw;

class VideoDTO
{
    public string $id;
    public string $title;
    public int $viewCount;
    public int $likeCount;
    public int $disLikeCount;
    public int $commentCount;

    public function __construct(
        string $id,
        string $title,
        int $viewCount,
        int $likeCount,
        int $disLikeCount,
        int $commentCount
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->viewCount = $viewCount;
        $this->likeCount = $likeCount;
        $this->disLikeCount = $disLikeCount;
        $this->commentCount = $commentCount;
    }
}