<?php

namespace Tirei01\Hw12;

class DomainObject
{
    protected $id;

    /**
     * @return int
     */
    public function getId() : int
    {
        return intval($this->id);
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }
}