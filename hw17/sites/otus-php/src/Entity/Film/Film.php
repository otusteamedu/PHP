<?php

declare(strict_types=1);

namespace App\Entity\Film;

use App\Entity\BaseEntity;

class Film extends BaseEntity
{
    protected $id;

    protected $name;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
}
