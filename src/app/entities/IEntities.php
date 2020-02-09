<?php

namespace Entity;

use Entity\Filter\IFilters;
use PDO;

interface IEntities
{
    public static function getById(PDO $pdo, int $id): IEntities;

    public static function getByFilter(PDO $pdo, IFilters $filter): array;

    public function isExists(): bool;

    public function fetchArray(): array;

    public function build(array $row): IEntities;

    public function create(): bool;

    public function update(): bool;

    public function delete(): bool;
}