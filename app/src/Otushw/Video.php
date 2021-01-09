<?php


namespace Otushw;

class Video
{
    private string $id;
    private string $title;
    private int $viewCount;
    private int $likeCount;
    private int $disLikeCount;
    private int $commentCount;

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

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return self
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return int
     */
    public function getViewCount(): int
    {
        return $this->viewCount;
    }

    /**
     * @param int $viewCount
     * @return self
     */
    public function setViewCount($viewCount): self
    {
        $this->viewCount = $viewCount;
        return $this;
    }

    /**
     * @return int
     */
    public function getLikeCount(): int
    {
        return $this->likeCount;
    }

    /**
     * @param int $likeCount
     * @return self
     */
    public function setLikeCount($likeCount): self
    {
        $this->likeCount = $likeCount;
        return $this;
    }

    /**
     * @return int
     */
    public function getDisLikeCount(): int
    {
        return $this->disLikeCount;
    }

    /**
     * @param int $disLikeCount
     * @return self
     */
    public function setDisLikeCount($disLikeCount): self
    {
        $this->disLikeCount = $disLikeCount;
        return $this;
    }

    /**
     * @return int
     */
    public function getCommentCount(): int
    {
        return $this->commentCount;
    }

    /**
     * @param int $commentCount
     * @return self
     */
    public function setCommentCount($commentCount): self
    {
        $this->commentCount = $commentCount;
        return $this;
    }
}
