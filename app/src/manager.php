<?php

namespace App;

use App\Db\Connect;
use App\Db\Repository;
use App\Service\RabbitService;
use Exception;

include_once __DIR__ . '/../vendor/autoload.php';

$config = new Config();
$connect = new Connect($config);
$repository = new Repository($connect);
$rabbitService = new RabbitService($config);

$callback = function ($msg) use ($repository) {
    $repository->update($msg->body, 'Ответ' . rand(0, 1000));
    echo 'Done request ' . $msg->body . PHP_EOL;
    $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
};

try {
    $rabbitService->consume($callback);
} catch (Exception $exception) {
    echo $exception->getMessage() . PHP_EOL;
}
