<?php

namespace Ozycast\App;

Class VideoModel extends ActiveRecord
{
    public $id;
    public $title;
    public $channelId;
    public $likes = 0;
    public $dislikes = 0;
    public $date_check = null;

    public static function getCollectName()
    {
        return 'videos';
    }

    public function save()
    {
        if (!strlen($this->id) || !strlen($this->title)) {
            $this->_error = "Properties empty";
            return 0;
        }

        App::$db->insert($this->getCollectName(), [
            "id" => $this->id,
            "channelId" => $this->channelId,
            "title" => $this->title,
            "likes" => $this->likes,
            "dislikes" => $this->dislikes,
            "date_check" => $this->date_check,
        ]);

        return 1;
    }

    public function update()
    {
        if (!strlen($this->id) || !strlen($this->title)) {
            $this->_error = "Properties empty";
            return 0;
        }

        App::$db->update(
            $this->getCollectName(),
            ["id" => $this->id],
            [
                "channelId" => $this->channelId,
                "title" => $this->title,
                "likes" => $this->likes,
                "dislikes" => $this->dislikes,
                "date_check" => $this->date_check,
            ]
        );

        return 1;
    }
}