<?php

namespace TimGa\Youtube;

class Channel
{
    public $name;
    public $description;
    public $author;

    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getName()
    {
        return $this->name;
    }
}
