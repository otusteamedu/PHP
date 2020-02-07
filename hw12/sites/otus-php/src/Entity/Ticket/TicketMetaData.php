<?php

declare(strict_types=1);

namespace App\Entity\Ticket;

use App\Entity\BaseMetaData;

class TicketMetaData extends BaseMetaData
{
    protected $table = 'ticket';
    protected $repository = 'App\Repository\TicketRepository';

    private $id = ['db_nullable' => false];

    private $session = [
        'db_nullable' => false,
        'table_col' => 'session_id',
        'reference' => 'App\Entity\Session\Session',
        'reference_property' => 'id'
    ];

    private $place = ['db_nullable' => false];

    private $price = ['db_nullable' => false];
}