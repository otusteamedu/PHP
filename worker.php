<?php

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$db = new SQLite3('src/Db/TaskStatus.db');

$channel = $connection->channel();

$channel->queue_declare('task_queue', false, true, false, false);

echo " [*] Waiting for tasks. To exit press CTRL+C\n";

$callback = static function ($msg) use ($db) {
    echo ' [x] Received new task, id - ', $msg->body, "\n";
    changeStatusToWorkInProcess($msg, $db);
    sleep(5);

    echo " [x] Done task\n";
    changeStatusFinish($msg, $db);

    $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
};

$channel->basic_qos(null, 1, null);
$channel->basic_consume('task_queue', '', false, false, false, false, $callback);

while (count($channel->callbacks)) {
    try {
        $channel->wait();
    } catch (ErrorException $e) {
        echo $e->getMessage();
    }
}

$channel->close();
try {
    $connection->close();
} catch (Exception $e) {
    echo $e->getMessage();
}


function changeStatusToWorkInProcess(AMQPMessage $msg, SQLite3 $db)
{
    $db->querySingle("UPDATE tasks SET status = '200' WHERE id = '$msg->body'");
}

function changeStatusFinish(AMQPMessage $msg, SQLite3 $db)
{
    $db->querySingle("UPDATE tasks SET status = '300' WHERE id = '$msg->body'");
}