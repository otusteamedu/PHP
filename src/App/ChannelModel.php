<?php

namespace Ozycast\App;

Class ChannelModel extends ActiveRecord
{
    public $id;
    public $title;

    public static function getCollectName(): string
    {
        return 'channels';
    }

    public function save(): bool
    {
        if (!strlen($this->id) || !strlen($this->title)) {
            $this->_error = "Properties empty";
            return 0;
        }

        App::$db->insert($this->getCollectName(), ["id" => $this->id, "title" => $this->title]);
        return 1;
    }

    public function update(): bool
    {
        if (!strlen($this->id) || !strlen($this->title)) {
            $this->_error = "Properties empty";
            return 0;
        }

        App::$db->update($this->getCollectName(), ["id" => $this->id], ["title" => $this->title]);
        return 1;
    }
}