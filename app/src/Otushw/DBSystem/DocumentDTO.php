<?php


namespace Otushw\DBSystem;


abstract class DocumentDTO
{
    const INDEX = [];

    /**
     * @return array
     */
    public function getDocumentStruct()
    {
        return self::INDEX;
    }

    /**
     * @return string
     */
    public function getDocumentName() {
        return '';
    }
}