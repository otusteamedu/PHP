<?php


namespace Otushw\DBSystem;

use Otushw\DBSystem\DocumentDTO;


abstract class NoSQLDAO
{
    protected $doc;
    protected $struct;
    protected $documentName;

    public function __construct(DocumentDTO $doc)
    {
        $this->doc = $doc;
        $this->struct = array_keys($doc->getDocumentStruct());
        $this->documentName = $doc->getDocumentName();
    }

    protected function isJSON($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    abstract public function create(array $source):bool;

    abstract public function read($id): array;

    abstract public function update($id, array $source): bool;

    abstract public function delete($id): bool;

    abstract public function getItems($limit = 10, $offset = 0): array;

    abstract public function getCount(): int;

    abstract public function getSumField($fieldName);

    abstract public function existDocStruct();

    abstract public function createDocStruct();
}