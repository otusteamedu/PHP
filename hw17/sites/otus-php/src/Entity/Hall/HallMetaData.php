<?php

declare(strict_types=1);

namespace App\Entity\Hall;

use App\Entity\BaseMetaData;

class HallMetaData extends BaseMetaData
{
    protected $table = 'hall';
    protected $repository = 'App\Repository\HallRepository';
    protected $entity = 'App\Entity\Hall\Hall';

    private $id = ['db_nullable' => false];

    private $name = ['db_nullable' => false];

    private $size = ['db_nullable' => false];
}
