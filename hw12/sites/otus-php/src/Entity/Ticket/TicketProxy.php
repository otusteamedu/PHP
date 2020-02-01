<?php

declare(strict_types=1);

namespace App\Entity\Ticket;

use App\Entity\BaseProxy;

class TicketProxy extends BaseProxy
{
    protected $id;

    protected $session;

    protected $place;

    protected $price;
}