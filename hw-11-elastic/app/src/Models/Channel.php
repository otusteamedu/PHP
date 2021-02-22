<?php

namespace Models;

class Channel extends Model
{
    public const TABLE_NAME = 'channels';

    private string $id;
    private string $title;
    private string $description;
    private string $thumbnail;

    public function __construct(
        string $id,
        string $title,
        string $description,
        string $thumbnail
    ) {
        $this->id          = $id;
        $this->title       = $title;
        $this->description = $description;
        $this->thumbnail   = $thumbnail;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getThumbnail(): string
    {
        return $this->thumbnail;
    }

    public function setThumbnail(string $thumbnail): self
    {
        $this->thumbnail = $thumbnail;
        return $this;
    }
}
