<?php

namespace App\EntityFilter;

interface IEntityFilter
{
    /**
     * @param array|null $assoc
     * @return array
     */
    public function fetchToAssoc(?array $assoc = null): array;

    /**
     * @param array $row
     * @return IEntityFilter
     */
    public static function buildFromAssoc(array $row): IEntityFilter;
}