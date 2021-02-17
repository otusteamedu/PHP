<?php

namespace Models;

class ChannelDTO
{
    public string $id;
    public string $title;
    public string $description;
    public string $thumbnail;

    public string $table = 'channels';

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
    }
}