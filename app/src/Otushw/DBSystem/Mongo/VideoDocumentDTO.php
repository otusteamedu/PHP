<?php


namespace Otushw\DBSystem\Mongo;

use Otushw\DBSystem\DocumentDTO;

class VideoDocumentDTO extends DocumentDTO
{
    const DOCUMENT_STRUCT = [
        'id' => ['$type' => 'string'],
        'title' => ['$type' => 'string'],
        'viewCount' => [
            '$type' => 'int',
        ],
        'likeCount' => [
            '$type' => 'int',
        ],
        'disLikeCount' => [
            '$type' => 'int',
        ],
        'commentCount' => [
            '$type' => 'int',
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
