<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\DataLoader\Generic;

use Nlazarev\Hw2_1\Model\DataSource\Generic\IDataSourceGeneric;

interface IDataLoaderGeneric
{
    public function getDataSource(): IDataSourceGeneric;
    public function load();
    public function isLoaded(): bool;
    public function toArray(): array;
}
