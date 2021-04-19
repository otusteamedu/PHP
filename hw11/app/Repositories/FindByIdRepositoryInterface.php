<?php

namespace App\Repositories;

use stdClass;

interface FindByIdRepositoryInterface
{
    /**
     * @param string $id
     *
     * @return stdClass
     */
    public function findById(string $id): stdClass;
}
