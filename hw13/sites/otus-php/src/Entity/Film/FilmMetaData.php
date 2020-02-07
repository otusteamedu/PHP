<?php

declare(strict_types=1);

namespace App\Entity\Film;

use App\Entity\BaseMetaData;

class FilmMetaData extends BaseMetaData
{
    protected $table = 'film';
    protected $repository = 'App\Repository\FilmRepository';
    protected $entity = 'App\Entity\Film\Film';

    private $id = ['db_nullable' => false];

    private $name = ['db_nullable' => false];
}