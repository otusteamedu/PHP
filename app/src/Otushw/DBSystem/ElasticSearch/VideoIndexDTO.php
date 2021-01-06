<?php


namespace Otushw\DBSystem\ElasticSearch;

use Otushw\DBSystem\IndexDTO;

class VideoIndexDTO extends IndexDTO
{
    const INDEX_STRUCT = [
        'id' => ['type' => 'text'],
        'title' => ['type' => 'text'],
        'viewCount' => ['type' => 'integer'],
        'likeCount' => ['type' => 'integer'],
        'disLikeCount' => ['type' => 'integer'],
        'commentCount' => ['type' => 'integer'],
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
