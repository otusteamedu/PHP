<?php


namespace Otushw;

use Otushw\DBSystem\ElasticSearch\VideoIndexDTO;
use Otushw\DBSystem\ElasticSearch\ElasticSearchDAO;
use Otushw\Youtube;

class App
{
    public function __construct()
    {
//        $elasticSearchDAO = new ElasticSearchDAO(new VideoIndexDTO());
////        $elasticSearchDAO->createIndex();
////        $elasticSearchDAO->getIndex();
//        $item = [
//            'id' => 'asd14',
//            'title' => 'Item3',
//            'viewCount' => 2222,
//            'likeCount' => 10,
//            'dislikeCount' => 1,
//            'commentCount' => 6,
//        ];
////        $r = $elasticSearchDAO->create($item);
////        $r = $elasticSearchDAO->read('asd13');
////        $r = $elasticSearchDAO->update('asd13', $item);
////        $r = $elasticSearchDAO->delete('asd12');
////        var_dump($r, 'aaa');
//
//        $videoMapper = new VideoMapper($elasticSearchDAO);
//
//        $v = $videoMapper->findById('asd12');
//        var_dump($v);

        $youtube = new Youtube();
        $youtube->getListVideos();
    }

}