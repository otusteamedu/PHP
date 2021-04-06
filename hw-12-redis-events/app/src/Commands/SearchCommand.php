<?php

namespace App\Commands;

use App\Storage\Storage;

class SearchCommand implements CommandInterface
{
    public function execute (array $params): string
    {
        if (!is_array($params) || empty($params)) {
            return json_encode(
                [
                    'result' => 'error',
                    'msg'    => 'bad "params" passed',
                ]
            );
        }

        $result = Storage::getInstance()->getStorage()->search($params);

        if (!$result) {
            return json_encode(
                [
                    'result' => 'error',
                    'msg'    => 'events not found',
                ]
            );
        }

        return json_encode(
            [
                'result' => 'success',
                'msg'    => 'OK',
                'event'  => json_decode($result),
            ]
        );
    }
}