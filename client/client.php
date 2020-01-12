<?php

use League\CLImate\CLImate;
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

$console = new CLImate;

$factory = new \Socket\Raw\Factory();
$client = $factory->createClient("unix://{$socketFile}");

$client->setBlocking(false);

echo 'Установлено подключение к серверу' . PHP_EOL;

do {

    $console->green()->inline('[Вы]: ');
    $message = trim(fgets(STDIN));

    $messageLength = strlen($message);
    if ($messageLength > $maxMessageByte) {
        $console->red()->out("Строка должна быть меньше {$maxMessageByte} байт, сейчас {$messageLength}.");
    } else {
        $client->write($message);
    }

    if ($message != 'пока') {
        if ($client->selectRead(1)) {
            $relpy = $client->recv($maxMessageByte, MSG_DONTWAIT);
            $console->yellow()->inline('[Сокет Бот]: ');
            $console->white()->out($relpy);
        }
    }

} while ($message !== 'пока');

$client->shutdown();
$client->close();