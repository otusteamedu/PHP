<?php

namespace Service\DataMapper;

use Model\Video;
use PDO;
use PDOStatement;

class VideoMapper
{
    const TABLE_NAME = 'videos';

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
            "select * from " . self::TABLE_NAME . " where channels_id = :channels_id"
        );

        $this->insertStmt = $pdo->prepare(
            "insert into " . self::TABLE_NAME . " (title, video_id, likes, dislikes, channels_id) values 
                (:title, :video_id, :likes, :dislikes, :channels_id)"
        );
        $this->updateStmt = $pdo->prepare(
            "update " . self::TABLE_NAME . " set title = :title, video_id = :video_id, likes = :likes, 
                dislikes = :dislikes, channels_id = :channels_id where id = :id"
        );
        $this->deleteStmt = $pdo->prepare("delete from " . self::TABLE_NAME . " where id = :id");
    }

    public function findById(int $id): ?Video
    {
        $this->selectStmt->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStmt->execute(['id' => $id]);
        $result = $this->selectStmt->fetch();
        if (!$result) {
            return null;
        }
        return new Video(
            $result['id'],
            $result['title'],
            $result['video_id'],
            $result['likes'],
            $result['dislikes'],
            $result['channels_id'],
        );
    }

    public function findAll(int $channelsId): array
    {
        $this->selectAllStmt->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectAllStmt->execute(['channels_id' => $channelsId]);
        $video = [];
        foreach ($this->selectAllStmt->fetchAll() as $result) {
            $video[] = new Video(
                $result['id'],
                $result['title'],
                $result['video_id'],
                $result['likes'],
                $result['dislikes'],
                $result['channels_id'],
            );
        }
        return $video;
    }


    public function insert(array $raw): Video
    {
        $this->insertStmt->execute([
            'title' => $raw['title'],
            'video_id' => $raw['video_id'],
            'likes' => $raw['likes'],
            'dislikes' => $raw['dislikes'],
            'channels_id' => $raw['channels_id']
        ]);
        return new Video(
            (int)$this->pdo->lastInsertId(),
            $raw['title'],
            $raw['video_id'],
            $raw['likes'],
            $raw['dislikes'],
            $raw['channels_id'],
        );
    }

    public function update(Video $video): bool
    {
        return $this->updateStmt->execute([
            'id' => $video->getId(),
            'title' => $video->getTitle(),
            'video_id' => $video->getVideoId(),
            'likes' => $video->getLikes(),
            'dislikes' => $video->getDislikes(),
            'channels_id' => $video->getChannelsId()
        ]);
    }

    public function delete(Video $video): bool
    {
        return $this->deleteStmt->execute(['id' => $video->getId()]);
    }
}
