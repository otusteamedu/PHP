<?php

namespace Structures;

use Exception;

class StructureReader
{
    protected const FILE_EXTENSION = 'json';
    protected const FILE_DIRECTORY = '../files/structures';

    protected string $indexName;
    protected string $fileName;
    protected string $filePath;

    public function __construct (string $indexName)
    {
        $this->indexName = $indexName;

        $this->setParams();
    }

    public function getPropertiesList (): array
    {
        return array_keys($this->readStructure()['body']['mappings']['properties'] ?? []);
    }

    protected function readStructure (): array
    {
        if (!file_exists($this->filePath)) {
            throw new Exception($this->indexName . ' structure file is not found');
        }

        $json = file_get_contents($this->filePath);

        return json_decode($json, true);
    }

    private function setParams (): void
    {
        $this->setFileName();
        $this->setFilePath();
    }

    private function setFilename (): void
    {
        $this->fileName = $this->indexName . '.' . self::FILE_EXTENSION;
    }

    private function setFilePath (): void
    {
        $this->filePath = self::FILE_DIRECTORY . '/' . $this->fileName;
    }
}