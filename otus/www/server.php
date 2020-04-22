<?php

require_once 'vendor/autoload.php';

use Classes\ServerSocketDataBuilder;

$settings = parse_ini_file('socket.ini');

$server = (new ServerSocketDataBuilder())
    ->setDomainServerSocketFilePath($settings['SERVER_SOCK_FILE_PATH'])
    ->setProtocolFamilyForSocket(AF_UNIX)
    ->setTypeOfDataExchange(SOCK_STREAM)
    ->setProtocol(0)
    ->setMaxByteForRead(65536)
    ->built();


try {
    $serverSocket = $server->socketCreate();
    echo "Сокет создан\n";

    $server->socketBind($serverSocket);
    echo "Сокет успешно связан с адресом\n";

    $server->socketListen($serverSocket);
    echo "Ждём подключение клиента\n";

} catch (Throwable $e) {
    echo $e->getMessage();
}


do {
    try {
        $clientSocket = $server->startConnectionWithSocket($serverSocket);
    } catch (Throwable $e) {
        echo $e->getMessage();
    }

    sleep(2);
    $msg = 'Привет';
    $server->write($clientSocket, $msg);

    do {
        try {
            $socketReadResult = $server->read($clientSocket);

            if (!$socketReadResult) {
                echo 'Ошибка при чтении сообщения от клиента';
            }

            if ($socketReadResult === 'exit') {
                $server->socketClose($clientSocket);
                break 2;
            }

            if ($socketReadResult === 'Принято') {
                echo sprintf("Сообщение %s принято клиентом\n", $msg);
            }

            $msg = random_int(1, 10000);


            $server->write($clientSocket, $msg);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    } while (true);
} while (true);

if (isset($serverSocket)) {
    $server->socketClose($serverSocket);
    echo 'Сокет успешно закрыт';
}
