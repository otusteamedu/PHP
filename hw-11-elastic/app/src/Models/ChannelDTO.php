<?php

namespace Models;

class ChannelDTO extends DTO
{
    public string $id;
    public string $title;
    public string $description;
    public string $thumbnail;
    public string $tableName;

    public function __construct (
        string $id,
        string $title,
        string $description,
        string $thumbnail
    )
    {
        $this->id          = $id;
        $this->title       = $title;
        $this->description = $description;
        $this->thumbnail   = $thumbnail;
        $this->tableName   = Channel::TABLE_NAME;
    }
}