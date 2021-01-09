<?php


namespace Otushw\DBSystem;

use Otushw\DBSystem\DocumentDTO;


abstract class NoSQLDAO
{
    protected DocumentDTO $doc;
    protected array $struct;
    protected string $documentName;

    public function __construct(DocumentDTO $doc)
    {
        $this->doc = $doc;
        $this->struct = array_keys($doc->getDocumentStruct());
        $this->documentName = $doc->getDocumentName();
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

    abstract public function create(array $source): bool;

    abstract public function read(int $id): array;

    abstract public function update(int $id, array $source): bool;

    abstract public function delete(int $id): bool;

    abstract public function getItems(int $limit = 10, int $offset = 0): array;

    abstract public function getCount(): int;

    abstract public function getSumField(string $fieldName): int;

    abstract public function existDocStruct(): bool;

    abstract public function createDocStruct(): bool;
}