<?php

namespace Src\StructureReaders;

/**
 * Class MongoStructureReader
 *
 * @package Src\StructureReaders
 */
class MongoStructureReader
{
    private string $indexName;

    private string $fileName;

    private string $filePath;

    private const TYPE_TRANSLATOR = [
        'integer' => 'int',
        'text' => 'string',
    ];

    public function __construct(string $indexName)
    {
        $this->indexName = $indexName;
        $this->setParams();
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getPropertiesList(): array
    {
        return array_keys($this->readStructure()['body']['mappings']['properties'] ?? []);
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function readStructure(): array
    {
        if (!file_exists($this->filePath)) {
            throw new \Exception($this->indexName . ' structure file is not found');
        }

        $json = file_get_contents($this->filePath);

        return \GuzzleHttp\json_decode($json, true);
    }

    private function setParams(): void
    {
        $this->setFileName();
        $this->setFilePath();
    }

    private function setFilename(): void
    {
        $this->fileName = $this->indexName . '.' . $_ENV['STRUCTURE_EXTENSION'];
    }

    private function setFilePath(): void
    {
        $this->filePath = $_SERVER['DOCUMENT_ROOT'] . $_ENV['STRUCTURE_PATH'] . '/' . $this->fileName;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getStructure(): array
    {
        $structure = [];

        $rawStructure = $this->readStructure()['body']['mappings']['properties'] ?? [];

        foreach ($rawStructure as $field => $type) {
            $structure[$field] = ['$type' => self::TYPE_TRANSLATOR[$type['type']] ?? $type['type']];
        }

        return $structure;
    }
}