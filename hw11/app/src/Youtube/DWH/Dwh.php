<?php


namespace Youtube\DWH;


use HW\Config;
use MongoDB\Client;
use MongoDB\Database;

class Dwh
{
    const COLLECT_CHANNELS = "channels";
    const COLLECT_VIDEOS = "videos";

    /** @var Client  */
    private $client = null;

    /** @var static */
    private static $instance = null;

    /** @var Database */
    private $db = null;


    /**
     * @return static
     */
    public static function getInst()
    {
        if (is_null(self::$instance))
            self::$instance = new static;

        return self::$instance;
    }

    private function __construct()
    {
        $cfg = Config::mongo();
        $param = "mongodb://" . $cfg['host'] . ":" . $cfg['port'];
        $db_name = $cfg['db_name'];

        $this->client = new Client($param);
        $this->db = $this->client->selectDatabase($db_name);
    }



    public function selectChannel($filter = [])
    {
        $data = $this->getChannels()->findOne($filter);
        return Channel::fromArray($data);
    }

    public function selectVideo($filter)
    {
        $data = $this->getVideos()->findOne($filter);
        return Video::fromArray($data);
    }



    /**
     * @param Item $item
     * @return \MongoDB\UpdateResult
     */
    public function insertOrUpdate($item)
    {
        $collect = $this->getCollectionByItem($item);

        $data = $item->toArray();

        $filter = ['_id' => $item->getID()];
        return $collect->updateOne($filter,['$set' => $data], ['upsert' => true]);
    }

    /**
     * @param Item $item
     */
    public function delete($item)
    {
        $filter = ['_id' => $item->getID()];
        return $this->getCollectionByItem($item)->deleteOne($filter);
    }


    /**
     * @param Item $item
     * @return \MongoDB\Collection|null
     */
    private function getCollectionByItem($item)
    {
        if ($item instanceof Channel)
            return $this->getChannels();
        elseif ($item instanceof Video)
            return $this->getVideos();
        else
            return null;
    }



    public function getChannels()
    {
        return $this->db->selectCollection(self::COLLECT_CHANNELS);
    }

    public function getVideos()
    {
        return $this->db->selectCollection(self::COLLECT_VIDEOS);
    }

    public function getDb()
    {
        return $this->db;
    }



}