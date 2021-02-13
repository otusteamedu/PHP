<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\DataLoader\Generic;

use Nlazarev\Hw2_1\Model\DataSource\Generic\IDataSourceGeneric;

abstract class DataLoaderGeneric implements IDataLoaderGeneric
{
    protected $data_source;
    protected $data;
    protected bool $loaded = false;

    public function getDataSource(): IDataSourceGeneric
    {
        return $this->data_source;
    }

    abstract public function load();

    public function isLoaded(): bool
    {
        return $this->loaded;
    }

    abstract public function toArray(): array;
}
