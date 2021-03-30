<?php

namespace App\Structures;

use App\Config\Config;
use Exception;

class StructureReader
{
    private string $structuresExtension;
    private string $structuresPath;
    private string $indexName;
    private string $fileName;
    private string $filePath;

    public function __construct (string $indexName)
    {
        $config = Config::getInstance();

        $this->structuresExtension = $config->getItem('structures_extension');
        $this->structuresPath      = $config->getItem('structures_path');
        $this->indexName           = $indexName;

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
        $this->fileName = $this->indexName . '.' . $this->structuresExtension;
    }

    private function setFilePath (): void
    {
        $this->filePath = $this->structuresPath . '/' . $this->fileName;
    }
}