<?php

namespace Classes;

class ResponseHandler
{

    public static function getControllerResponseData(array $result)
    {
        return json_encode($result, JSON_THROW_ON_ERROR, 512);
    }
}
