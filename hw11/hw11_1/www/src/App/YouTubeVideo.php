<?php

namespace App;

use MongoDB\Client;

class YouTubeVideo extends MongoDatabase
{
    private $_insert_id;
    private $id = '';
    private $channelId = '';
    private $title = '';
    private $description = '';
    private $dislike = 0;
    private $like = 0;
    private const COLLECTION_NAME='VideosCollection';

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
    public function getChannelId(): string
    {
        return $this->channelId;
    }

    /**
     * @param string $channelId
     */
    public function setChannelId(string $channelId): void
    {
        $this->channelId = $channelId;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getDislike(): int
    {
        return $this->dislike;
    }

    /**
     * @param int $dislike
     */
    public function setDislike(int $dislike): void
    {
        $this->dislike = $dislike;
    }

    /**
     * @return int
     */
    public function getLike(): int
    {
        return $this->like;
    }

    /**
     * @param int $like
     */
    public function setLike(int $like): void
    {
        $this->like = $like;
    }

    /**
     * @return \MongoDB\InsertOneResult
     */
    public function save()
    {
        $this->mongoCollection = $this->mongoClient->selectCollection(self::DB_NAME, self::COLLECTION_NAME);
        $insertResult = $this->mongoCollection->insertOne([
            'channelId' => $this->channelId,
            'id' => $this->id,
            "title" => $this->title,
            "description" => $this->description,
            'dislike' => $this->dislike,
            'like' => $this->like
        ]);
        $this->_insert_id = $insertResult->getInsertedId();
        return $insertResult;
    }

    /**
     * @param $videoId
     * @return YouTubeVideo
     */
    public static function getById($videoId): YouTubeVideo
    {
        $mongoClient = new Client('mongodb://mongodb');
        $mongoCollection = $mongoClient->selectCollection(self::DB_NAME, self::COLLECTION_NAME);
        $findOneResult = $mongoCollection->findOne(['id' => $videoId]);

        $new = new self($mongoClient);
        $new->setChannelId($findOneResult["channelId"]);
        $new->setId($findOneResult["id"]);
        $new->setTitle($findOneResult["title"]);
        $new->setDescription($findOneResult["description"]);
        $new->setDisLike($findOneResult["dislike"]);
        $new->setLike($findOneResult["like"]);
        return $new;
    }
}