<?php

namespace Structures;

class MongoStructureReader extends StructureReader
{
    private const TYPE_TRANSLATOR = [
        'integer' => 'int',
        'text'    => 'string',
    ];

    public function getStructure (): array
    {
        $structure = [];

        $rawStructure = $this->readStructure()['body']['mappings']['properties'] ?? [];

        foreach ($rawStructure as $field => $type) {
            $structure[$field] = ['$type' => self::TYPE_TRANSLATOR[$type['type']] ?? $type['type']];
        }

        return $structure;
    }
}