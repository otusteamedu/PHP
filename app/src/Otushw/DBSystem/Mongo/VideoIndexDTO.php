<?php


namespace Otushw\DBSystem\Mongo;

use Otushw\DBSystem\IndexDTO;

class VideoIndexDTO extends IndexDTO
{
    const INDEX_STRUCT = [
        'id' => ['bsonType' => 'string'],
        'title' => ['bsonType' => 'string'],
        'viewCount' => [
            'bsonType' => 'int',
            'minimum' => 0
        ],
        'likeCount' => [
            'bsonType' => 'int',
            'minimum' => 0
        ],
        'disLikeCount' => [
            'bsonType' => 'int',
            'minimum' => 0
        ],
        'commentCount' => [
            'bsonType' => 'int',
            'minimum' => 0
        ],
    ];

    const INDEX_NAME = 'video';

    public function getIndexStruct()
    {
        return self::INDEX_STRUCT;
    }

    public function getIndexName()
    {
        return self::INDEX_NAME;
    }
}
