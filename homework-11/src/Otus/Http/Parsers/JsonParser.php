<?php

namespace Otus\Http\Parsers;

use JsonException;

class JsonParser implements ParserContract
{
    public function parse(): array
    {
        try {
            $data = json_decode($this->body(), true, 512, JSON_THROW_ON_ERROR) ?? [];
        } catch (JsonException $exception) {
            $data = [];
        }

        return $data + $_GET;
    }

    private function body()
    {
        $stream = fopen('php://input', 'rb');

        return stream_get_contents($stream);
    }
}
