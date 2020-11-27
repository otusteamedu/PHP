<?php

namespace Otus;

class Post
{
    private $storage;

    public function __construct()
    {
        $this->storage = $_POST;
    }

    public function __get($name)
    {
        if (isset($this->storage[$name])) return $this->storage[$name];
    }

    public function getRequestEntries()
    {
        return $this->storage;
    }

}