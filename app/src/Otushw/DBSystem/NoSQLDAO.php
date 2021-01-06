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

    public function create(array $source):bool
    {
        return false;
    }

    public function read($id): array
    {
        return [];
    }

    public function update($id, array $source): bool
    {
        return false;
    }

    public function delete($id): bool
    {
        return false;
    }

    protected function isJSON($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    public function getItems($limit = 10, $offset = 0): array
    {
        return [];
    }

    public function getCount(): int
    {
        return 0;
    }

    public function getSumField($fieldName)
    {
        return 0;
    }
}