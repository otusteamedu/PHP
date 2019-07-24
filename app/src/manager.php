<?php

include_once __DIR__ . '/../vendor/autoload.php';

use App\Connect;
use PhpAmqpLib\Connection\AMQPStreamConnection;

$dbType = 'pgsql';
$host = 'otus-postgres';
$dbName = 'cinema';
$user = 'cinema';
$password = '1231';

$connection = new AMQPStreamConnection('otus-rabbitmq', 5672, 'admin', '1231');
$channel = $connection->channel();
$channel->queue_declare('manager', false, true, false, false);

$callback = function ($msg) use ($dbType, $host, $dbName, $user, $password) {
    try {
        $connect = new Connect($dbType, $host, $dbName, $user, $password);
        $stmt = $connect->getPdo()->prepare("UPDATE request SET status = 1, answer = 'Ответ" . rand(0, 1000 ) . "' WHERE MD5(id::VARCHAR(255)) = ?");
        $stmt->execute([$msg->body]);
        echo 'Done request ' . $msg->body . PHP_EOL;

        $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);

    } catch (\Exception $exception) {
        echo $exception->getMessage() . PHP_EOL;
    }
};

$channel->basic_qos(null, 1, null);
$channel->basic_consume('manager', '', false, false, false, false, $callback);

while ($channel->is_consuming()) {
    $channel->wait();
}

$channel->close();
$connection->close();
