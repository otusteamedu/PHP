<?php

declare(strict_types=1);

namespace App\Entities;

class YouTubeChannel
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
     * @var string
     */
    protected $categoryId;
    /**
     * @var string
     */
    protected $categoryTitle;
    /**
     * @var VideoCollection
     */
    protected $videos;

    public function __construct()
    {
        $this->videos = new VideoCollection();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return YouTubeChannel
     */
    public function setId(string $id): YouTubeChannel
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
     * @return YouTubeChannel
     */
    public function setTitle(string $title): YouTubeChannel
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
     * @return YouTubeChannel
     */
    public function setDescription(string $description): YouTubeChannel
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getCategoryId(): string
    {
        return $this->categoryId;
    }

    /**
     * @param string $category
     * @return YouTubeChannel
     */
    public function setCategoryId(string $category): YouTubeChannel
    {
        $this->categoryId = $category;
        return $this;
    }

    /**
     * @return string
     */
    public function getCategoryTitle(): string
    {
        return $this->categoryTitle;
    }

    /**
     * @param string $categoryTitle
     * @return YouTubeChannel
     */
    public function setCategoryTitle(string $categoryTitle): YouTubeChannel
    {
        $this->categoryTitle = $categoryTitle;
        return $this;
    }

    /**
     * @return VideoCollection
     */
    public function getVideos(): VideoCollection
    {
        return $this->videos;
    }

    /**
     * @param YouTubeVideo[] $videos
     * @return YouTubeChannel
     */
    public function addVideos(array $videos): YouTubeChannel
    {
        $this->videos->addVideos($videos);
        return $this;
    }

    /**
     * @param YouTubeVideo $video
     */
    public function addVideo(YouTubeVideo $video): void
    {
        $this->videos->addVideo($video);
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
            'category' => [
                'id' => $this->categoryId,
                'title' => $this->categoryTitle,
            ],
            'videos' => $this->videos->toArray(),
        ];
    }

    /**
     * @return int
     */
    public function totalLikesCount(): int
    {
        return array_reduce($this->getVideos()->toArray(), function ($sum, $video) {
            return $sum += $video['statistics']['likeCount'];
        }, 0);
    }

    /**
     * @return int
     */
    public function totalDislikesCount(): int
    {
        return array_reduce($this->getVideos()->toArray(), function ($sum, $video) {
            return $sum += $video['statistics']['dislikeCount'];
        }, 0);
    }

    /**
     * @return float
     */
    public function likesDislikesRatio(): float
    {
        return round($this->totalLikesCount() / $this->totalDislikesCount(),2);
    }

    /**
     * @param $object
     * @return YouTubeChannel
     */
    public static function createFromObject($object): YouTubeChannel
    {
        if (!is_object($object)) {
            throw new \InvalidArgumentException('Invalid parameter, object required.');
        }

        $channel = new self;

        foreach ($object as $key => $value) {
            if ($key === 'videos') {
                foreach ($object->videos as $video) {
                    $channel->addVideo(YouTubeVideo::createFromObject($video));
                }
            } elseif ($key === 'category') {
                foreach ($object->category as $categoryKey => $categoryValue) {
                    $setterName = 'setCategory' . ucfirst($categoryKey);
                    if (method_exists($channel, $setterName)) {
                        $channel->{$setterName}($categoryValue);
                    }
                }
            } elseif (is_string($key)) {
                $setterName = 'set' . ucfirst($key);
                if (method_exists($channel, $setterName)) {
                    $channel->{$setterName}($value);
                }
            }
        }

        return $channel;
    }
}
