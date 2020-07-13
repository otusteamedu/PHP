<?php

namespace YoutubeApp;

use MongoDB\Collection;

class AddDataToCollectionModel extends ChannelsModel
{
    public function setNameField(string $name): ChannelsModel
    {
        $this->name = $name;
        return $this;
    }

    public function setDescriptionField(string $description): ChannelsModel
    {
        $this->description = $description;
        return $this;
    }

    public function setVideosField(array $videos): ChannelsModel
    {
        $this->videos = $videos;
        return $this;
    }

    public function addDocument(): object
    {
        $result =  $this->mongoCollection->insertOne([
            'name' => $this->name,
            'description' => $this->description,
            'videos' => $this->videos
        ]);
        return $result->getInsertedId();
    }
}
