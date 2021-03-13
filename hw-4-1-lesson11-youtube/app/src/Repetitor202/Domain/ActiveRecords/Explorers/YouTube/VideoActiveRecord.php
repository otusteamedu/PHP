<?php


namespace Repetitor202\Domain\ActiveRecords\Explorers\YouTube;


use Repetitor202\Application\Clients\SQL\ElasticsearchClient;
use Repetitor202\Application\Clients\SQL\MongoDbClient;

class VideoActiveRecord
{
    public const TABLE = 'youtube_videos';
    private ?string $sqlClientClassname;

    private string $id;
    private string $channelId;
    private int $likeCount;
    private int $dislikeCount;
    private string $title;

    public function __construct()
    {
        switch ($_ENV['SQL_CLIENT']) {
            case ElasticsearchClient::STORAGE_NAME:
                $this->sqlClientClassname = ElasticsearchClient::class;
                break;
            case MongoDbClient::STORAGE_NAME:
                $this->sqlClientClassname = MongoDbClient::class;
                break;
            default:
                $this->sqlClientClassname = null;
        }
    }

    public function insert(): bool
    {
        return $this->sqlClientClassname::createOneItem(
            self::TABLE,
            [
                'channelId' => $this->getChannelId(),
                'likeCount' => $this->getLikeCount(),
                'dislikeCount' => $this->getDislikeCount(),
                'title' => $this->getTitle(),
            ],
            $this->getId()
        );
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getChannelId(): string
    {
        return $this->channelId;
    }

    public function setChannelId(string $channelId): void
    {
        $this->channelId = $channelId;
    }

    public function getLikeCount(): int
    {
        return $this->likeCount;
    }

    public function setLikeCount(int $likeCount): void
    {
        $this->likeCount = $likeCount;
    }

    public function getDislikeCount(): int
    {
        return $this->dislikeCount;
    }

    public function setDislikeCount(int $dislikeCount): void
    {
        $this->dislikeCount = $dislikeCount;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
}