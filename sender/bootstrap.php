<?php

use Otus\Sender;
use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__ . "/vendor/autoload.php";

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . "/.env");


if (empty($_POST)) {
    include __DIR__ . "/template/main.php";
}
else {
    try {
        $text = json_encode($_POST);
        $sender = new Sender();
        $sender->sendMessage($text);
        echo "Сообщение отправлено";
    } catch (Exception $e) {
        echo "Произошла ошибка: " . $e->getMessage();
    }
}



