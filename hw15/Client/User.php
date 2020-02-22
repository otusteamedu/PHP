<?php

declare(strict_types=1);

namespace App\Client;

class User
{
    public const CLIENT_TYPE = 'b2c';

    protected $id;

    protected $type;

    protected $name;

    protected $email;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }
}