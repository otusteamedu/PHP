<?php
require_once '../bootstrap/bootstrap.php';

try {

    $redis = new Redis();
    var_dump($redis->connect('redis', 6379));

    $test = [
        "priority" => 1000,
        "params" => [
            'param1' => 2,
            'param2' => 2
        ],
        "event" => [
            'event' => 'some_event'
        ]
    ];

    $test2 = [
        "priority" => 1001,
        "params" => [
            'param1' => 1,
            'param2' => 2
        ],
        "event" => [
            'event' => 'some_event'
        ]
    ];
    $redis->zAdd('key', $test['priority'], json_encode($test['params']));
    $redis->zAdd('key', $test2['priority'], json_encode($test2['params']));

    print_r($redis->zPopMax('key',1));
    print_r($redis->zPopMax('key',1));
    print_r($redis->zPopMax('key',1));
//        $redis->zRange('key', 0, -1);
//    print_r($redis->zRevRange('key', 0, -1, true));
//    $redis->zRemRangeByScore('key',0,1500);
//    var_dump($redis->zRevRange('key', 0, -1, true));
    $redis->close();
//    $app = new App();
//    $app->run();
} catch (\Exception $e) {
    echo $e->getMessage();
}
