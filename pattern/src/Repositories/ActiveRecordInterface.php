<?php

namespace Src\Repositories;

interface ActiveRecordInterface
{
    public static function tableName() : string;

    public static function getAll(\PDO $PDO) : array;
}