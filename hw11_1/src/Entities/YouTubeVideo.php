<?php

declare(strict_types=1);

namespace App\Entities;

class YouTubeVideo
{
    /**
     * @var string
     */
    protected $id;
    /**
     * @var string
     */
    protected $title;
    /**
     * @var string
     */
    protected $description;
    /**
     * @var int
     */
    protected $viewsCount;
    /**
     * @var int
     */
    protected $likeCount;
    /**
     * @var int
     */
    protected $dislikeCount;
    /**
     * @var int
     */
    protected $commentCount;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return YouTubeVideo
     */
    public function setId(string $id): YouTubeVideo
    {
        $this->id = $id;
        return $this;
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
     * @return YouTubeVideo
     */
    public function setTitle(string $title): YouTubeVideo
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return YouTubeVideo
     */
    public function setDescription(string $description): YouTubeVideo
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return int
     */
    public function getViewsCount(): int
    {
        return $this->viewsCount;
    }

    /**
     * @param int $viewsCount
     * @return YouTubeVideo
     */
    public function setViewsCount(int $viewsCount): YouTubeVideo
    {
        $this->viewsCount = $viewsCount;
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
     * @return YouTubeVideo
     */
    public function setLikeCount(int $likeCount): YouTubeVideo
    {
        $this->likeCount = $likeCount;
        return $this;
    }

    /**
     * @return int
     */
    public function getDislikeCount(): int
    {
        return $this->dislikeCount;
    }

    /**
     * @param int $dislikeCount
     * @return YouTubeVideo
     */
    public function setDislikeCount(int $dislikeCount): YouTubeVideo
    {
        $this->dislikeCount = $dislikeCount;
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
     * @return YouTubeVideo
     */
    public function setCommentCount(int $commentCount): YouTubeVideo
    {
        $this->commentCount = $commentCount;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'statistics' => [
                'viewsCount' => $this->viewsCount,
                'likeCount' => $this->likeCount,
                'dislikeCount' => $this->dislikeCount,
                'commentCount' => $this->commentCount,
            ],
        ];
    }

    /**
     * @param $object
     * @return YouTubeVideo
     */
    public static function createFromObject($object): YouTubeVideo
    {
        if (!is_object($object)) {
            throw new \InvalidArgumentException('Invalid parameter, object required.');
        }

        $data = get_object_vars($object);

        $video = new self;

        foreach ($data as $key => $value) {
            if ($key === 'statistics') {
                foreach ($data['statistics'] as $count => $countValue) {
                    $setterName = 'set' . ucfirst($count);
                    $video->{$setterName}($countValue);
                }
            } elseif (is_string($key) && property_exists(self::class, $key)) {
                $setterName = 'set' . ucfirst($key);
                $video->{$setterName}($value);
            }
        }

        return $video;
    }
}
