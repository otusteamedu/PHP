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
    }
}