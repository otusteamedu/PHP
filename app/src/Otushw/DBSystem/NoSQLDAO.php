<?php


namespace Otushw\DBSystem;

use Otushw\StorageInterface;

abstract class NoSQLDAO implements StorageInterface
{
    protected array $struct;
    protected string $documentName;

    public function __construct()
    {
        $this->setDocumentName($_ENV['NAME_DATASET']);
        $this->setDocumentStruct($_ENV['SCHEMA']);

        if (!$this->existDocStruct()) {
            $this->createDocStruct();
        }
    }

    /**
     * @param string $arg
     *
     * @return bool
     */
    protected function isJSON(string $arg): bool
    {
        json_decode($arg);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    private function setDocumentStruct(array $schema)
    {
        $this->struct = array_keys($schema);
    }

    /**
     * @return array
     */
    public function getDocumentStruct(): array
    {
        return $this->struct;
    }

    private function setDocumentName(string $name)
    {
        $this->documentName = $name;
    }

    /**
     * @return string
     */
    public function getDocumentName(): string
    {
        return $this->documentName;
    }

    abstract public function existDocStruct(): bool;

    abstract public function createDocStruct(): bool;
}
