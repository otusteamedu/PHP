<?php

namespace Src\StructuresReader;

/**
 * Class ElasticSearchReader
 *
 * @package Src\StructuresReader
 */
class ElasticSearchStructureReader
{
    private string $indexName;

    private string $fileName;

    private string $filePath;

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

        return json_decode($json, true);
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getStructure(): array
    {
        return $this->readStructure();
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
}