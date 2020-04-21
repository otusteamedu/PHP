<?php

require_once 'vendor/autoload.php';

use Classes\ServerSocketDataBuilder;

header('Content-Type: text/plain;');
set_time_limit(0);
ob_implicit_flush();


$server = (new ServerSocketDataBuilder())
    ->setDomainServerSocketFilePath(__DIR__. '/server.sock')
    ->setDomainClientSocketFilePath(__DIR__. '/app.sock')
    ->setProtocolFamilyForSocket(AF_UNIX)
    ->setTypeOfDataExchange(SOCK_DGRAM)
    ->setProtocol(0)
    ->setMaxByteForRead(65536)
    ->built();


try {
    $socket = $server->socketCreate();
    echo "Сокет создан\n";
} catch (Throwable $e) {
    echo $e->getMessage();
}

try {
    $res = $server->socketBind($socket);
    echo "Сокет успешно связан с адресом и портом\n";
} catch (Throwable $e) {
    echo $e->getMessage();
}



do {

    sleep(2);
    $msg = 'Привет';
    $server->write($socket, $msg);

    do {
        $socketReadResult = $server->read($socket);

        if (!$socketReadResult) {
            echo 'Ошибка при чтении сообщения от клиента';
        }

        if ($socketReadResult === 'exit') {
            $server->socketClose($socket);
            break 2;
        }

        if ($socketReadResult === 'Принято') {
            echo sprintf("Сообщение %s принято клиентом\n", $msg);
        }

        $msg = mt_rand(1, 10000);

        $server->write($socket, $msg);

    } while (true);
} while (true);

if (isset($socket)) {
    $server->socketClose($socket);
    echo 'Сокет успешно закрыт';
}
