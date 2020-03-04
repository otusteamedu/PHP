<?php

namespace App\EntityInterface;

interface IEntityFetchAssoc
{
    /**
     * @param array|null $assoc
     * @return array
     */
    public function fetchParams(array $assoc = []): array;
}