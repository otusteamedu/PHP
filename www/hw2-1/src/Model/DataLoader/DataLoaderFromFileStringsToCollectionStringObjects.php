<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\DataLoader;

use Nlazarev\Hw2_1\Model\Collections\Generic\ICollectionGeneric;
use Nlazarev\Hw2_1\Model\DataLoader\FromFile\IDataLoaderFromFileStrings;
use Nlazarev\Hw2_1\Model\DataLoader\ToCollection\IDataLoaderToCollection;
use Nlazarev\Hw2_1\Model\DataSource\File\IDataSourceFileStrings;
use Nlazarev\Hw2_1\Model\General\String\StringObject;

class DataLoaderFromFileStringsToCollectionStringObjects implements IDataLoaderFromFileStrings, IDataLoaderToCollection
{
    private $strings = array();

    public function fromFileStrings(IDataSourceFileStrings $file)
    {
        if ($file->isReadable()) {
            $this->strings = file($file->getPath(), FILE_IGNORE_NEW_LINES);
        }
    }

    public function toCollection(ICollectionGeneric $collection)
    {
        foreach ($this->strings as $key => $value) {
            $collection->push(new StringObject($value));
        }
    }
}
