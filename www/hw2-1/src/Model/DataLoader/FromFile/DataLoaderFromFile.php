<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\DataLoader\FromFile;

use Nlazarev\Hw2_1\Model\DataLoader\Generic\DataLoaderGeneric;
use Nlazarev\Hw2_1\Model\DataSource\File\IDataSourceFile;

class DataLoaderFromFile extends DataLoaderGeneric implements IDataLoaderFromFile
{
    protected $data_source;
    protected $data = array();

    public function getDataSource(): IDataSourceFile
    {
        return parent::getDataSource();
    }

    public function setDataSourceAsFile(IDataSourceFile $data_source)
    {
        $this->loaded = false;
        $this->data_source = $data_source;
    }

    public function load()
    {
        if ($this->data = file($this->getDataSource()->getSource()->getPath(), FILE_IGNORE_NEW_LINES)) {
            $this->loaded = true;
        } else {
            $this->loaded = false;
            throw new \Exception("DataSource not loaded as file");
        }
    }

    public function toArray(): array
    {
        return $this->data;
    }
}
