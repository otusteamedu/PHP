<?php

namespace Classes;

class JsonHandler
{

    public static function getJson(array $result)
    {
        return json_encode($result, JSON_THROW_ON_ERROR, 512);
    }

    public static function getFromJson(string $json)
    {
        return json_decode($json, true, 512, JSON_THROW_ON_ERROR);
    }
}
