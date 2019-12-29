<?php

$user = '';
while (!$user) {
    echo "Введите имя пользователя или 'exit' для выхода:  ";
    $user = trim(fgets(STDIN));
    if ($user === 'exit') {
        exit();
    }
}

while (true) {
    echo "Напишите сообщение или 'exit' для выхода:  ";
    $msg = trim(fgets(STDIN));
    if ($msg === 'exit') {
        exit();
    } elseif ($msg) {
        try {
            $sock = stream_socket_client('unix://./unix.sock',  $errno, $errstr);
            if (is_resource($sock)) {
                fwrite($sock, "$user:   $msg");
            } else {
                echo "Не удалось создать сокет!" . PHP_EOL;
            }
        } catch (Exception $e) {
            echo "Произошла ошибка: " . $e->getMessage() . PHP_EOL;
        }
    }
}