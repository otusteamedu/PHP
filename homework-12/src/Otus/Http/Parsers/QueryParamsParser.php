<?php

namespace Otus\Http\Parsers;

class QueryParamsParser implements ParserContract
{
    public function parse(): array
    {
        return $_GET;
    }
}
