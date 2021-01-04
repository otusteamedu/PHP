<?php

namespace App\Command;

use App\Core\AbstractController;
use MongoDB\Client;
use MongoDB\Model\BSONDocument;

class TestController extends AbstractController
{
    public function indexAction()
    {
        $mongo = new Client('mongodb://root:pass@mongo/');
        $collection = $mongo->selectDatabase('youtube')->selectCollection('channels');

        $items = $collection->find(['views' => [ '$gt' => 700000]]);
        foreach ($items as $item) {
            /** @var BSONDocument $item */
            print_r([$item->list[0]->name]);
        }

//        foreach (range(11, 13) as $item) {
//            $collection->insertOne([
//                'id' => $item,
//                'name' => 'Channel '.uniqid(),
//                'videos' => rand(1, 100),
//                'views' => rand(1000, 1000000),
//                'list' => [
//                    ['name' => 'Video '.uniqid(), 'views' => rand(100, 10000)]
//                ]
//            ]);
//            print $item.' added'.PHP_EOL;
//        }

    }
}