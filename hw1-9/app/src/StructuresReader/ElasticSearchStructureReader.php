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
    private string $channelStructurePath;

    public function __construct (string $indexName)
    {
        $this->indexName = $indexName;
        $this->channelStructurePath = $_SERVER['DOCUMENT_ROOT'].$_ENV['STRUCTURE_PATH'];
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getPropertiesList (): array
    {
        return array_keys($this->readStructure()['body']['mappings']['properties'] ?? []);
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function readStructure(): array
    {
        if (!file_exists($this->channelStructurePath)) {
            throw new \Exception($this->indexName . ' structure file is not found');
        }

        $json = file_get_contents($this->channelStructurePath);

        return json_decode($json, true);
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getStructure (): array
    {
        return $this->readStructure();
    }
}