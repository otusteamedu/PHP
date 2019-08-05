<?php

declare(strict_types=1);

namespace app;

class Video
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $title;

    /**
     * @var int
     */
    public $duration;

    /**
     * @var Stats
     */
    public $stats;

    /**
     * @var string
     */
    public $publishedAt;

    public function __construct(array $params = [])
    {
        $this->stats = new Stats();

        foreach ($params as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
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
     */
    public function setId(string $id): void
    {
        $this->id = $id;
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
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return int
     */
    public function getDuration(): int
    {
        return $this->duration;
    }

    /**
     * @param int $duration
     */
    public function setDuration(int $duration): void
    {
        $this->duration = $duration;
    }

    /**
     * @return Stats
     */
    public function getStats(): Stats
    {
        return $this->stats;
    }

    /**
     * @param Stats $stats
     */
    public function setStats(Stats $stats): void
    {
        $this->stats = $stats;
    }

    /**
     * @return string
     */
    public function getPublishedAt(): string
    {
        return $this->publishedAt;
    }

    /**
     * @param string $publishedAt
     */
    public function setPublishedAt(string $publishedAt): void
    {
        $this->publishedAt = $publishedAt;
    }

    public static function convertISO8601ToSeconds(string $iso8601duration): int
    {
        $interval = new \DateInterval($iso8601duration);
        return $interval->h * 3600 + $interval->i * 60 + $interval->s;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'duration' => $this->getDuration(),
            'likes' => $this->getStats()->likes,
            'dislikes' => $this->getStats()->dislikes,
            'views' => $this->getStats()->views,
            'comments_count' => $this->getStats()->commentsCount,
            'published_at' => $this->getPublishedAt()
        ];
    }
}