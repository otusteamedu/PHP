<?php

require_once 'vendor/autoload.php';

use Classes\ServerSocketDataBuilder;
use Classes\SocketException;
use Classes\SocketServer;

$settings = parse_ini_file('socket.ini');

if (file_exists($settings['SERVER_SOCK_FILE_PATH'])) {
    unlink($settings['SERVER_SOCK_FILE_PATH']);
}

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

    handle_client($server, $clientSocket);
} while (true);

function handle_client(SocketServer $server, $clientSocket) {
    $pid = pcntl_fork();

    if ($pid === -1) {
        /* fork failed */
        echo "fork failure!\n";
        die;
    }

    if ($pid === 0) {
        /* child process */
        try {
            interact($server, $clientSocket);
        } catch (\Exception $e) {
            echo $e->getMessage() . "\n";
        }
    }

    socket_close($clientSocket);
}

/**
 * @param SocketServer $server
 * @param $clientSocket
 * @throws SocketException
 * @throws Exception
 */
function interact(SocketServer $server, $clientSocket) {
    $msg = 'Привет';
    $server->write($clientSocket, $msg);

    do {
        $socketReadResult = $server->read($clientSocket);

        if (!$socketReadResult) {
            echo 'Ошибка при чтении сообщения от клиента';
        }

        if ($socketReadResult === 'exit') {
            $server->socketClose($clientSocket);
            return;
        }

        if ($socketReadResult === 'Принято') {
            echo sprintf("Сообщение %s принято клиентом\n", $msg);
        }

        $msg = random_int(1, 10000);


        $server->write($clientSocket, $msg);
    } while (true);
}

if (isset($serverSocket)) {
    $server->socketClose($serverSocket);
    echo 'Сокет успешно закрыт';
}
