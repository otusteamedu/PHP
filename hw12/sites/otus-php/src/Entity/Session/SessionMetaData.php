<?php

declare(strict_types=1);

namespace App\Entity\Session;

use App\Entity\BaseMetaData;

class SessionMetaData extends BaseMetaData
{
    protected $table = 'session';
    protected $repository = 'App\Repository\SessionRepository';

    private $id = ['db_nullable' => false];

    private $film = [
        'db_nullable' => false,
        'table_col' => 'film_id',
        'reference' => 'App\Entity\Film\Film',
        'reference_property' => 'id'
    ];

    private $hall = [
        'db_nullable' => false,
        'table_col' => 'hall_id',
        'reference' => 'App\Entity\Hall\Hall',
        'reference_property' => 'id'
    ];

    private $start = ['db_nullable' => false];
}