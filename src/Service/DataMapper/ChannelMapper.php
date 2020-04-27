<?php

namespace Service\DataMapper;

use Model\Channel;
use PDO;
use PDOStatement;

class ChannelMapper
{
    const TABLE_NAME = 'channels';

    private PDO $pdo;

    private PDOStatement $selectStmt;

    private PDOStatement $selectAllStmt;

    private PDOStatement $updateStmt;

    private PDOStatement $insertStmt;

    private PDOStatement $deleteStmt;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;

        $this->selectStmt = $pdo->prepare(
            "select * from " . self::TABLE_NAME . " where id = :id"
        );

        $this->selectAllStmt = $pdo->prepare(
            "select * from " . self::TABLE_NAME . " limit :limit"
        );

        $this->insertStmt = $pdo->prepare(
            "insert into " . self::TABLE_NAME . " (title, channel_id) values (:title, :channel_id)"
        );
        $this->updateStmt = $pdo->prepare(
            "update " . self::TABLE_NAME . " set title = :title, channel_id = :channel_id where id = :id"
        );
        $this->deleteStmt = $pdo->prepare("delete from " . self::TABLE_NAME . " where id = :id");
    }

    public function findById(int $id): ?Channel
    {
        $this->selectStmt->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStmt->execute(['id' => $id]);
        $result = $this->selectStmt->fetch();
        if (!$result) {
            return null;
        }

        $channel = new Channel();
        $channel->fill($result);

        $videoMapper = new VideoMapper($this->pdo);
        $videosRef = function () use ($videoMapper, $id) {
            return $videoMapper->findAll($id);
        };
        $channel->setVideos($videosRef);
        return $channel;
    }

    public function findAll(int $limit = 5): array
    {
        $this->selectAllStmt->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectAllStmt->execute(['limit' => $limit]);
        $channels = [];
        $videoMapper = new VideoMapper($this->pdo);
        foreach ($this->selectAllStmt->fetchAll() as $result) {
            $channel = new Channel();
            $channel->fill($result);
            $channelId = $result['id'];
            $videosRef = function () use ($videoMapper, $channelId) {
                return $videoMapper->findAll($channelId);
            };
            $channel->setVideos($videosRef);
            $channels[] = $channel;
        }
        return $channels;
    }


    public function insert(array $raw): Channel
    {
        $this->insertStmt->execute([
            'title' => $raw['title'],
            'channel_id' => $raw['channel_id']
        ]);
        if (is_array($raw['videos'])) {
            $videoMapper = new VideoMapper($this->pdo);
            foreach ($raw['videos'] as $video) {
                $videoMapper->insert(array_merge($video, ['channels_id' => (int)$this->pdo->lastInsertId()]));
            }
        }
        $channel = new Channel();
        $channel->fill($raw);
        $channel->setId((int)$this->pdo->lastInsertId());
        return $channel;
    }

    public function update(Channel $channel): bool
    {
        return $this->updateStmt->execute([
            'id' => $channel->getId(),
            'title' => $channel->getTitle(),
            'channel_id' => $channel->getChannelId()
        ]);
    }

    public function delete(Channel $channel): bool
    {
        return $this->deleteStmt->execute(['id' => $channel->getId()]);
    }
}
