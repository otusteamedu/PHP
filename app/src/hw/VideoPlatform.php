<?php

namespace VideoPlatform;

use VideoPlatform\helpers\ArrayHelper;
use VideoPlatform\interfaces\DBInterface;
use VideoPlatform\interfaces\VideoSharingPlatformInterface;

class VideoPlatform
{
    private VideoSharingPlatformInterface $platform;
    private array $data;
    private DBInterface $db;

    public function __construct(VideoSharingPlatformInterface $platform, DBInterface $db)
    {
        $this->platform = $platform;
        $this->db = $db;
    }

    /**
     * вернет данные канала
     * @return array
     */
    public function analyze() : array
    {
        return $this->platform->getChannelDetail();
    }

    /**
     * сохраняет данные у бд
     * @return bool
     * @throws \Exception
     */
    public function save() : bool
    {
        $this->db->connect();
        $data = ArrayHelper::getCorrectFormat($this->db, $this->data);

        return $this->db->save($data);
    }
}