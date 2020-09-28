<?php

namespace Otus;

class ChannelSanitizer
{
    public static function sanitize(array $data): array
    {
        return [
            'id'               => $data['id'] ?? '',
            'title'            => $data['title'] ?? '',
            'description'      => $data['description'] ?? '',
            'like_count'       => (int) $data['like_count'],
            'dislike_count'    => (int) $data['dislike_count'],
            'ratio'            => (float) $data['ratio'],
        ];
    }
}