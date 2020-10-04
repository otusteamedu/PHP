<?php

namespace Otus;

use Otus\Exceptions\InvalidEventDataException;

class EventSanitizer
{
    /**
     * @param  array  $data
     *
     * @throws \Otus\Exceptions\InvalidEventDataException
     * @return array
     */
    public static function sanitize(array $data): array
    {
        if ($data['priority'] === null) {
            throw new InvalidEventDataException('Priority value is required.');
        }

        if ($data['conditions'] === null || ! is_array($data['conditions'])) {
            throw new InvalidEventDataException('Conditions array is required.');
        }

        if ($data['event'] === null) {
            throw new InvalidEventDataException('Event value is required.');
        }


        return [
            'priority'   => (int) $data['priority'],
            'conditions' => $data['conditions'],
            'event'      => $data['event'],
        ];
    }
}
