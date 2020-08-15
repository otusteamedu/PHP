<?php

namespace Services;

class Spider implements \Sources\MethodsInterface {
    private $source = NULL;
    private $db = NULL;
    private $result = [];

    public function __construct($source, $db)
    {
        $this->source = $this->source ?? $source;
        $this->db = $this->db ?? $db;
        $this->result = [];
    }

    public function getTop() : Object
    {
        $this->result[] = $this->source->getTop();

        return $this;
    }

    public function getAll() : Object
    {
        return $this;
    }

    public function getPage(int $page) : Object
    {
        return $this;
    }
}
