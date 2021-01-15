<?php

namespace VideoPlatform\models\youtube;

use VideoPlatform\interfaces\DBInterface;

class Channel
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
    private $tableName = 'channels';

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

        $channel = new self();
        $channel->setId($result['id']);
        $channel->setDescription($result['description']);
        $channel->setSubscriberCount($result['subscriberCount']);
        $channel->setTitle($result['title']);
        $channel->setVideoCount($result['videoCount']);
        $channel->setViewCount($result['viewCount']);

        return $channel;
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
