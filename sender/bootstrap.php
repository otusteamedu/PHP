<?php

use Otus\Sender;

require_once __DIR__ . "/vendor/autoload.php";

if (!empty($_POST)) {
    include __DIR__ . "/template/main.php";
}
else {
    $text = json_encode($_POST);
    $sender = new Sender('rabbitmq', 5672, 'otus', 'otus', 123, "hello");
    $sender->sendMessage($text);
    echo "Сообщение отправлено";
}



