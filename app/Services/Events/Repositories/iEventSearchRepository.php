<?php


namespace App\Services\Events\Repositories;


interface iEventSearchRepository
{
    public function getByCondition(array $conditions): ?array;
}
