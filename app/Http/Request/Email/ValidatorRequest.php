<?php

namespace app\Http\Request\Email;

class ValidatorRequest
{
    static public function getData(): array
    {
        return file(__DIR__.'/emailsList.txt', FILE_IGNORE_NEW_LINES);
    }
}