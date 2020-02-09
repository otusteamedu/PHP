<?php

namespace App;

use MongoDB\Client;

class YouTubeChannel extends MongoDatabase
{
    private $id = '';
    private $login = '';
    private $title = '';
    private $description = '';
    private $videoIds = [];
    private const COLLECTION_NAME='ChannelsCollection';

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @param string $login
     */
    public function setLogin(string $login): void
    {
        $this->login = $login;
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
    public function setTitle(string $title = null): void
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
    public function setDescription(string $description = null): void
    {
        $this->description = $description;
    }

    /**
     * @return array|null
     */
    public function getVideoIds(): ?array
    {
        return $this->videoIds;
    }

    /**
     * @param array|null $videoIds
     */
    public function setVideoIds($videoIds = []): void
    {
        $this->videoIds = $videoIds;
    }

    public function save()
    {
        $this->mongoCollection = $this->mongoClient->selectCollection(self::DB_NAME, self::COLLECTION_NAME);
        $insertResult = $this->mongoCollection->insertOne([
            'id' => $this->id,
            'login' => $this->login,
            "title" => $this->title,
            "description" => $this->description,
            "videoIds" => $this->videoIds,
        ]);
        $this->_insert_id = $insertResult->getInsertedId();
        return $insertResult;
    }

    /**
     * @param $channelId
     * @return YouTubeChannel
     */
    public static function getById($channelId): YouTubeChannel
    {
        $mongoClient =  new Client('mongodb://mongodb');
        $mongoCollection = $mongoClient->selectCollection(self::DB_NAME, self::COLLECTION_NAME);
        $findOneResult = $mongoCollection->findOne(['id' => $channelId]);

        $new = new self($mongoClient);
        $new->setId($findOneResult["id"]);
        $new->setLogin($findOneResult["login"]);
        $new->setTitle($findOneResult["title"]);
        $new->setDescription($findOneResult["description"]);
        $new->setVideoIds($findOneResult["videoIds"]->bsonSerialize());
        return $new;
    }

    /**
     * @param $channelLogin
     * @return YouTubeChannel
     */
    public static function getByLogin($channelLogin): YouTubeChannel
    {
        $mongoClient =  new Client('mongodb://mongodb');
        $mongoCollection = $mongoClient->selectCollection(self::DB_NAME, self::COLLECTION_NAME);
        $findOneResult = $mongoCollection->findOne(['login' => $channelLogin]);

        $new = new self($mongoClient);
        $new->setId($findOneResult["id"]);
        $new->setLogin($findOneResult["login"]);
        $new->setTitle($findOneResult["title"]);
        $new->setDescription($findOneResult["description"]);
        $new->setVideoIds($findOneResult["videoIds"]->bsonSerialize());
        return $new;
    }


    /**
     * @return array
     */
    public function getAllData()
    {
        $mongoClient =  new Client('mongodb://mongodb');
        $mongoCollection = $mongoClient->selectCollection(self::DB_NAME, self::COLLECTION_NAME);
        return $mongoCollection->find()->toArray();
    }
}