<?php

namespace App;

use RuntimeException;

final class YouTube
{
    public static function search(string $q, int $limit = 5): object
    {
        return self::curl('search', [
            'part' => 'snippet',
            'type' => 'video',
            'order' => 'relevance', // relevance | rating | viewCount
            'regionCode' => 'RU',
            'relevanceLanguage' => 'ru',
            'maxResults' => $limit,
            'q' => $q,
        ]);
    }

    public static function getVideo(string $id): ?object {
        $data = self::curl('videos', [
            'part' => 'snippet',
            'id' => $id,
        ]);
        if (empty($data->items[0]->id)) {
            return null;
        }
        $obj = clone $data->items[0]->snippet;
        $obj->_id = $data->items[0]->id;

        $data = self::curl('videos', [
            'part' => 'statistics',
            'id' => $id,
        ]);
        if (empty($data->items[0]->statistics)) {
            return $obj;
        }
        $obj->statistics = clone $data->items[0]->statistics;

        return $obj;
    }

    public static function getChannel(string $id): ?object {
        $data = self::curl('channels', [
            'part' => 'snippet',
            'id' => $id,
        ]);
        if (empty($data->items[0]->id)) {
            return null;
        }
        $obj = clone $data->items[0]->snippet;
        $obj->_id = $data->items[0]->id;
        return $obj;
    }

    private static function curl(string $path, array $request) {
        $base_url = 'https://www.googleapis.com/youtube/v3/';
        $request['key'] = getenv('APP_KEY_YOUTUBE');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $base_url . $path . '?' . http_build_query($request));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json']);

        $result = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            throw new RuntimeException($error);
        }

        try {
            $ret = json_decode($result, false, 512, JSON_THROW_ON_ERROR);
        } catch (Throwable $e) {
            throw new RuntimeException('Wrong responce');
        }

        if (isset($ret->error)) {
            throw new RuntimeException(strip_tags($ret->error->message));
        }

        return $ret;
    }
}
