<?php


namespace Otushw\DBSystem\ElasticSearch;

use Otushw\DBSystem\DocumentDTO;

class VideoDocumentDTO extends DocumentDTO
{
    const DOCUMENT_STRUCT = [
        'id' => ['type' => 'text'],
        'title' => ['type' => 'text'],
        'viewCount' => ['type' => 'integer'],
        'likeCount' => ['type' => 'integer'],
        'disLikeCount' => ['type' => 'integer'],
        'commentCount' => ['type' => 'integer'],
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
