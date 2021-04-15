<?php

namespace App\Storage;

use App\Config\Config;
use Exception;
use Symfony\Component\Yaml\Exception\ParseException;

class MysqlConfigValidator
{
    public static function validate($keys): void
    {
        foreach ($keys as $item) {
            $dbConfig = Config::getInstance()->getItem(Storage::DB_CONFIG_KEY);

            if (!isset($dbConfig[$item])) {
                throw new Exception("Database config '$item' is not found");
            }
        }
    }
}

/*CREATE TABLE films
(
    id              serial       NOT NULL,
    title           varchar(100) NOT NULL,
    show_start_date timestamp    NOT NULL,
    length          int4         NOT NULL,
    CONSTRAINT films_pk PRIMARY KEY (id),
    CONSTRAINT films_title_and_date_un UNIQUE (title, show_start_date)
);*/