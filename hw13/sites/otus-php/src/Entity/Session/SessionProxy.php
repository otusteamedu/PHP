<?php

declare(strict_types=1);

namespace App\Entity\Session;

use App\Entity\BaseProxy;

class SessionProxy extends BaseProxy
{
    protected $id;

    protected $film;

    protected $hall;

    protected $start;
}