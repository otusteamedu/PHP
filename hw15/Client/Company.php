<?php

declare(strict_types=1);

namespace App;

class Company
{
    public const CLIENT_TYPE = 'b2b';

    protected $id;

    protected $type;

    protected $companyName;

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