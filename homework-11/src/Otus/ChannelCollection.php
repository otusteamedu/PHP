<?php

namespace Otus;

use Otus\Exceptions\InvalidDataFormatException;

class ChannelCollection
{
    public array $items = [];

    /**
     * ChannelCollection constructor.
     *
     * @param  array  $data
     *
     * @throws \Otus\Exceptions\InvalidDataFormatException
     */
    public function __construct(array $data)
    {
        if (! isset($data['hits']['hits'])) {
            throw new InvalidDataFormatException();
        }

        foreach ($data['hits']['hits'] as $item) {
            $data = ChannelSanitizer::sanitize($item['_source']);

            $this->items[] = Channel::make($data);
        }
    }
}