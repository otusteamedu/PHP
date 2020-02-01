<?php

declare(strict_types=1);

namespace App\Entity\Session;

use App\Entity\BaseEntity;

class Session extends BaseEntity
{
    protected $id;

    protected $film;

    protected $hall;

    protected $start;
}
