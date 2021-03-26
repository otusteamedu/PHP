<?php


namespace Otushw\ServerAPI\Controllers;

class BaseController
{
    protected function isJSON(string $data): bool
    {
        json_decode($data);
        return (json_last_error() == JSON_ERROR_NONE);
    }

}