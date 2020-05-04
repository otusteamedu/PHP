<?php

namespace Ozycast\App\DTO;

use Ozycast\App\Core\DTO;
use Ozycast\App\Relationship\VideoRelationship;

Class Video extends DTO
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $title;
    /**
     * @var string
     */
    private $channelId;
    /**
     * @var int
     */
    private $likes = 0;
    /**
     * @var int
     */
    private $dislikes = 0;
    /**
     * @var int
     */
    private $dateCheck = 0;

    /**
     * @var \Ozycast\App\DTO\Channel|null
     */
    private $channel = null;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Video
     */
    public function setId(string $id): self
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
     * @return Video
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getChannelId(): string
    {
        return $this->channelId;
    }

    /**
     * @param string $channelId
     * @return Video
     */
    public function setChannelId(string $channelId): self
    {
        $this->channelId = $channelId;
        return $this;
    }

    /**
     * @return int
     */
    public function getLikes(): int
    {
        return $this->likes;
    }

    /**
     * @param string $likes
     * @return Video
     */
    public function setLikes(string $likes): self
    {
        $this->likes = (int) $likes;
        return $this;
    }

    /**
     * @return int
     */
    public function getDislikes(): int
    {
        return $this->dislikes;
    }

    /**
     * @param int $dislikes
     * @return Video
     */
    public function setDislikes(int $dislikes): self
    {
        $this->dislikes = (int) $dislikes;
        return $this;
    }

    /**
     * @return int
     */
    public function getDateCheck(): int
    {
        return $this->dateCheck;
    }

    /**
     * @param int $dateCheck
     * @return Video
     */
    public function setDateCheck(int $dateCheck): self
    {
        $this->dateCheck = (int) $dateCheck;
        return $this;
    }

    /**
     * Relationship
     * @return Channel
     */
    public function getChannel(): Channel
    {
        if (is_null($this->channel))
            $this->channel = VideoRelationship::channel($this);

        return $this->channel;
    }
}