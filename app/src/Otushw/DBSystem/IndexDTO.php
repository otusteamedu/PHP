<?php


namespace Otushw\DBSystem;


abstract class IndexDTO
{
    const INDEX = [];

    /**
     * @return array
     */
    public function getIndexStruct()
    {
        return self::INDEX;
    }

    /**
     * @return string
     */
    public function getIndexName() {
        return '';
    }
}