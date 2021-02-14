<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\AppEmailValidation\DataLoader;

use Nlazarev\Hw2_1\Model\Collections\Generic\ICollectionGeneric;
use Nlazarev\Hw2_1\Model\DataLoader\FromFile\DataLoaderFromFile;
use Nlazarev\Hw2_1\Model\General\String\StringObject;

final class DataLoader extends DataLoaderFromFile implements IDataLoader
{
    public function toCollection(ICollectionGeneric $collection)
    {
        if ($this->isLoaded()) {
            $strings = $this->toArray();
            foreach ($strings as $key => $value) {
                $collection->push(new StringObject($value));
            }
        }
    }
}
