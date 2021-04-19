<?php

namespace App\Repositories;

use stdClass;

interface FindManyByIdsRepositoryInterface
{
    /**
     * @param array $ids
     *
     * @return stdClass
     */
    public function findManyByIds(array $ids): stdClass;
}
