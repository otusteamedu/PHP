<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\DataSource\Generic;

abstract class DataSourceGeneric implements IDataSourceGeneric
{
    protected $source;

    public function getSource()
    {
        return $this->source;
    }

    //abstract public function setSource($source);
}
