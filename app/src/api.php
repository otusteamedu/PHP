<?php

use App\Connect;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

include_once __DIR__ . '/../vendor/autoload.php';

$dbType = 'pgsql';
$host = 'otus-postgres';
$dbName = 'cinema';
$user = 'cinema';
$password = '1231';

function getResponse(int $code, string $message) {
    echo json_encode([
        'code' => $code,
        'status' => $code === 200 ? 'ok' : 'error',
        'message' => $message,
    ]);

    exit;
}

if (!isset($_GET['mode'])) {
    getResponse(500, 'Internal Server Error. No mode parameter.');
}

$data = file_get_contents('php://input');
$data = json_decode($data, true);

if ($_GET['mode'] === 'send') {
    if (empty($data['message'])) {
        getResponse(500, 'No message passed.');
    }

    try {
        $connect = new Connect($dbType, $host, $dbName, $user, $password);
        $stmt = $connect->getPdo()->prepare('INSERT INTO request (question) VALUES (:question)');
        $stmt->bindParam('question', $data['message']);
        $stmt->execute();
        $id = $connect->getPdo()->lastInsertId();
    } catch (\Exception $exception) {
        getResponse(500, 'Internal Server Error. ' . $exception->getMessage());
    }

    echo json_encode([
        'code' => 200,
        'status' => 'ok',
        'message' => md5($id),
    ]);

    $connection = new AMQPStreamConnection('otus-rabbitmq', 5672, 'admin', '1231');
    $channel = $connection->channel();
    $channel->queue_declare('manager', false, true, false, false);

    $msg = new AMQPMessage(md5($id), ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]);
    $channel->basic_publish($msg, '', 'manager');

    $channel->close();
    $connection->close();

    exit;
}

if ($_GET['mode'] === 'get') {
    try {
        $connect = new Connect($dbType, $host, $dbName, $user, $password);
        $stmt = $connect->getPdo()->prepare('SELECT * FROM request WHERE MD5(id::VARCHAR(255)) = :code');
        $stmt->bindParam('code', $data['code']);
        $stmt->execute();
        $res = $stmt->fetch();
    } catch (\Exception $exception) {
        getResponse(500,'Internal Server Error. ' . $exception->getMessage());
    }

    $message = 'Статус: ';
    if ($res['status'] === 1) $message .= 'обработано';
    else $message .= 'не обработано';
    $message .= '<br>Ваш вопрос: ' . $res['question'];
    $message .= '<br>Ответ: ' . $res['answer'];

    getResponse(200, $message);
}

getResponse(500, 'Wrong API url.');