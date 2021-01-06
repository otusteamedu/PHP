<?php


namespace Otushw\DBSystem\Mongo;

use Otushw\DBSystem\DocumentDTO;

class VideoDocumentDTO extends DocumentDTO
{
    const DOCUMENT_STRUCT = [
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

    const DOCUMENT_NAME = 'video';

    public function getDocumentStruct()
    {
        return self::DOCUMENT_STRUCT;
    }

    public function getDocumentName()
    {
        return self::DOCUMENT_NAME;
    }
}
