<?php

use Noodlehaus\Config;

set_time_limit (0);
ob_implicit_flush ();

require 'vendor/autoload.php';

if (PHP_SAPI !== 'cli') {
    echo 'Сервер должен был запущен в консольном режиме.';
    echo PHP_EOL;
}

$config = Config::load('config/main.yaml');
$socketFile = $config->get('socket_file');
$maxMessageByte = $config->get('max_message_byte');

if (file_exists($socketFile)) {
    unlink($socketFile);
}

$socketBot = new \App\SocketBot();

$factory = new \Socket\Raw\Factory();
$server = $factory->createServer("unix://{$socketFile}");

$server->setBlocking(false);

echo 'Сервер ждёт соединений...' . PHP_EOL;

while (true) {

    if ($server->selectRead(1)) {

        $client = $server->accept();

        echo 'Установлено новое соединение' . PHP_EOL;

        do {
            $message = $client->read($maxMessageByte);
            echo '[client]: ' . $message . PHP_EOL;

            if (($message !== 'пока')) {
                if ($client->selectWrite(1)) {
                    $client->send($socketBot->sayReplyTo($message), 0);
                }
            }

        } while ($message !== 'пока');

        $client->close();

        echo 'Соединение закрыто' . PHP_EOL;
    }

    usleep(100000);
}

$server->shutdown();
$server->close();

unlink($socketFile);