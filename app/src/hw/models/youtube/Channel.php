<?php

namespace VideoPlatform\models\youtube;

use VideoPlatform\interfaces\DBInterface;
use VideoPlatform\models\ActiveRecord;
use VideoPlatform\models\ObjectWatcher;

class Channel extends ActiveRecord
{
    private $id;
    private $title;
    private $description;
    private $viewCount;
    private $subscriberCount;
    private $videoCount;

    /**
     * название таблицы или индекса
     * @var $table
     */
    private string $tableName = 'channels';

    /**
     * @return mixed
     */
    public function getTableName()
    {
        return $this->tableName;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @param mixed $viewCount
     */
    public function setViewCount($viewCount): void
    {
        $this->viewCount = $viewCount;
    }

    /**
     * @param mixed $subscriberCount
     */
    public function setSubscriberCount($subscriberCount): void
    {
        $this->subscriberCount = $subscriberCount;
    }

    /**
     * @param mixed $videoCount
     */
    public function setVideoCount($videoCount): void
    {
        $this->videoCount = $videoCount;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getSubscriberCount()
    {
        return $this->subscriberCount;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getVideoCount()
    {
        return $this->videoCount;
    }

    /**
     * @return mixed
     */
    public function getViewCount()
    {
        return $this->viewCount;
    }

    /**
     * @param DBInterface $db
     * @param $id
     * @return Channel
     */
    public static function findById(DBInterface $db, $id): self
    {
        $result = $db->findById((new self())->tableName, $id);

        $identityMap = ObjectWatcher::getRecord(self::class, $id);

        if ($identityMap) {
            return  $identityMap;
        }

        $channel = new self();
        $channel->setId($result['id']);
        $channel->setDescription($result['description']);
        $channel->setSubscriberCount($result['subscriberCount']);
        $channel->setTitle($result['title']);
        $channel->setVideoCount($result['videoCount']);
        $channel->setViewCount($result['viewCount']);

        ObjectWatcher::addRecord($channel, $channel->getId());

        return $channel;
    }

    public static function getAll(DBInterface $db, $limit = 100, $offset = 0)
    {
        $response = $db->getAll((new self())->getTableName(), $limit, $offset);

        $result = [];

        while (isset($response['hits']['hits']) && count($response['hits']['hits']) > 0) {

            foreach ($response['hits']['hits'] as $hit){
                $result[] = $hit;
            }

            $offset = $limit + $offset;
            $response = $db->getAll((new self())->getTableName(), $limit, $offset);
        }

        return $result;
    }

    /**
     * @param DBInterface $db
     */
    public function save(DBInterface $db)
    {
        $db->save($this->getProperties());
    }

    /**
     * @return array
     */
    public function getProperties()
    {
        return get_object_vars($this);
    }
}
