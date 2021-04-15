<?php

namespace App\Commands;

use App\Models\FilmMapper;
use App\Storage\Storage;

class GetCommand implements CommandInterface
{
    private const DEFAULT_LIMIT  = 20;
    private const DEFAULT_OFFSET = 0;

    public function execute (array $params): string
    {
        $limit  = isset($params['limit']) ? intval($params['limit']) : self::DEFAULT_LIMIT;
        $offset = isset($params['offset']) ? intval($params['offset']) : self::DEFAULT_OFFSET;

        $mapper     = new FilmMapper(Storage::getInstance());
        $collection = $mapper->getRecords($limit, $offset);

        if (is_null($collection)) {
            $records = [];
        }
        else {
            $records = $collection->getRecords();
        }

        return json_encode(
            [
                'result' => 'success',
                'msg'    => 'OK',
                'data'   => $records,
            ]
        );
    }
}