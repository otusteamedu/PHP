<?php


namespace Youtube\DWH;


class Video extends Item
{
    private $channelID = '';

    public function __construct($videoID, $channelID, $data = [])
    {
        parent::__construct($videoID, $data);
        $this->channelID = $channelID;
    }

    public function getChannelID()
    {
        return $this->channelID;
    }

    public function setCountLikes($likes)
    {
        $this->data['statistics']['likes'] = intval($likes);
    }

    public function setCountDislikes($dislikes)
    {
        $this->data['statistics']['dislikes'] = intval($dislikes);
    }

    public function getCountLikes()
    {
        return $this->data['statistics']['likes'] ?? 0;
    }

    public function getCountDislikes()
    {
        return $this->data['statistics']['dislikes'] ?? 0;
    }

    public function toArray()
    {
        $data = parent::toArray();
        $data['channel_id'] = $this->getChannelID();
        $data['statistics']['likes'] = intval($this->getCountLikes());
        $data['statistics']['dislikes'] = intval($this->getCountDislikes());
        return $data;
    }

    public static function fromArray($data)
    {
        $id = $data['video_id'] ?? 0;
        $chID = $data['channel_id'] ?? 0;

        if (!$id || !$chID)
            return null;

        $item = new static($id, $chID);
        $item->setCountLikes($data['statistics']['likes'] ?? 0);
        $item->setCountDislikes($data['statistics']['dislikes'] ?? 0);

        return $item;
    }

}