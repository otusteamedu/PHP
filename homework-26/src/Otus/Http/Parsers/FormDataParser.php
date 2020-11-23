<?php


namespace Otus\Http\Parsers;


class FormDataParser implements ParserContract
{
    public function parse(): array
    {
        return $_POST + $_GET;
    }
}
