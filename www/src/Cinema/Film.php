<?php

namespace Tirei01\Hw12\Cinema;

use Tirei01\Hw12\DomainObject;

class Film extends DomainObject
{
    public function __construct($id, $name)
    {
        $this->setId($id);
        $this->setName($name);
    }
}