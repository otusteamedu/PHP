<?php

namespace App\Structures;

class ElasticStructureReader extends StructureReader
{
    public function getStructure (): array
    {
        return $this->readStructure();
    }
}