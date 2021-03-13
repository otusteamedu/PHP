<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Elasticsearch\ClientBuilder;

$client = ClientBuilder::create()
    ->setHosts(['192.168.10.3'])
    ->build();

//var_dump($client);


$queryParams = [
    'index' => 'youtube_channels_test2',
    'ignore_unavailable' => true,
    'id' => 'c1111',
];
//$res = $client->get($queryParams);
try {

    $res = $client->get($queryParams);
} catch (Exception $e) {
    echo 1111;
}
//var_dump($res);




// good
//$queryParams = [
//    'index' => 'youtube_channels_test',
//    'body' => [
//        'query' => [
//            'match' => [
//                'title' => 'qqq2'
//            ],
//        ],
//    ],
//];
//$res = $client->search($queryParams);
//var_dump($res);

//$queryParams = [
//    'index' => 'youtube_channels_test',
//    'id' => 'c1'
////    'body' => [
////        'query' => [
////            'match' => [
////                'title' => 'qqq2'
////            ],
////        ],
////    ],
//];
//$res = $client->get($queryParams);
//var_dump($res);

// good
//$queryParams = [
//    'index' => 'youtube_channels_test',
//    'body' => [
//        'query' => [
//            'match' => [
//                'title' => 'qqq234'
//            ],
//        ],
//    ],
//];
//$res = $client->deleteByQuery($queryParams);
//var_dump($res);









//$insertResult = $client->index($queryParams);
//var_dump(is_array($insertResult));

////try {
////    $insertResult = $client->index($queryParams);
////    if ($insertResult->getInsertedCount()) {
////        return true;
////    }
////} catch (Exception $e) {
////    return false;
////}
////return false;
//
//
//
//// insert one
//$source = $queryParams;
//$source['_id'] = 1;
//try {
//    $insertOneResult = $client->collection1->insertOne($source);
//    if ($insertOneResult->getInsertedCount()) {
//        echo 'return true';
//    }
//} catch (Exception $e) {
//    echo 'return false1';
//}
//echo 'return false2';