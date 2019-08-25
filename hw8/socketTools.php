<?php

function validateSentData(int $bytesSent, int $length): void
{
    if (!$bytesSent) {
        die('An error occured while sending to the socket' . PHP_EOL);
    }

    if ($bytesSent != $length) {
        die($bytesSent . ' bytes have been sent instead of the ' . $length . ' bytes expected' . PHP_EOL);
    }
}

function deleteSocketIfExist(string $socket): void
{
    if (file_exists($socket)) {
        unlink($socket);
        echo "The socket $socket has been deleted" . PHP_EOL;
    }
}

function validateSocket($socket): void
{
    if (!$socket) {
        die('Unable to create AF_UNIX socket' . PHP_EOL);
    }
}

function bindSocket($socket, string $path): void
{
    if (!socket_bind($socket, $path)) {
        die("Unable to bind to $path" . PHP_EOL);
    }
}

function setBlock($socket): void
{
    if (!socket_set_block($socket)) {
        die('Unable to set blocking mode for the socket' . PHP_EOL);
    }
}

function setNonblock($socket): void
{
    if (!socket_set_nonblock($socket)) {
        die('Unable to set nonblocking mode for the socket' . PHP_EOL);
    }
}


// Костылище. Непонятно почему в конце лишний символ добавляется ¯\_(ツ)_/¯
function getProperClientAddress(string $address): string
{
    return substr($address, 0, -1);
}

function getData($socket): array
{
    $buffer = '';
    $client = '';
    $bytesReceived = socket_recvfrom($socket, $buffer, 65536, 0, $client);

    if ($bytesReceived === false) {
        die('An error occured while receiving from the socket: ' . socket_last_error($socket));

    }

    return [
        'socket' => getProperClientAddress($client),
        'data' => $buffer
    ];
}

function sentData($socket, string $client, string $dataToSent): void
{
    $length = strlen($dataToSent);
    $bytesSent = socket_sendto($socket, $dataToSent, $length, 0, $client);
    validateSentData($bytesSent, $length);
}