<?php

namespace App\Repositories;

use App\Models\BaseModel;

interface CUDRepositoryInterface
{
    /**
     * @param BaseModel $model
     */
    public function insert(BaseModel $model): void;

    /**
     * @param BaseModel $model
     */
    public function delete(BaseModel $model): void;
}
