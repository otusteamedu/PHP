<?php

namespace Classes\Models;

class Film extends AbstractActiveRecord
{
    protected $id;
    protected $name;

    protected static $tableName = 'films';

    public function setName(string $name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

    public function setId(int $id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }
}
