#!/usr/bin/env php
<?php

declare(ticks=1);

use \crazydope\socket\SocketFactory;
use \crazydope\socket\SocketServerInterface;
use \crazydope\socket\SocketInterface;
use \crazydope\socket\SocketException;

require '../vendor/autoload.php';

const SERVER_ADDRESS = 'tcp://127.0.0.1:1337';
const ALLOW_USER_ATTEMPTS = 3;

$client = null;
$serverListening = true;
$number = 0;
$userAttempt = 0;

pcntl_signal(SIGTERM, 'sigHandler', false);
pcntl_signal(SIGINT, 'sigHandler', false);

function sigHandler()
{
    global $serverListening;
    echo 'Received quit signal, finishing tasks... ' . PHP_EOL;
    $serverListening = false;
}

/**
 * @param SocketServerInterface $server
 * @return SocketInterface|null
 * @throws Exception
 */
function getNewPlayer(SocketServerInterface $server): ?SocketInterface
{
    try {
        $client = $server->accept();
        $welcomeText = 'Hi! I\'ve picked a random number between 1 and 10. Can you guess it?' . PHP_EOL;
        $welcomeText .= 'You have ' . ALLOW_USER_ATTEMPTS . ' attempts. ';
        $welcomeText .= 'Type "exit" to quit.';
        $client->write($welcomeText);
        return $client;
    } catch (SocketException $e) {
        echo $e->getMessage() . PHP_EOL;
        return null;
    }
}

/**
 * @param SocketInterface $socket
 * @param string $msg
 * @return SocketInterface
 */
function closeSocket(SocketInterface $socket, string $msg): SocketInterface
{
    $socket->write($msg);
    $socket->close();
    return $socket;
}


$server = (new SocketFactory())->createServer(SERVER_ADDRESS);
echo 'Server address: ' . SERVER_ADDRESS . PHP_EOL;

while ($serverListening) {

    if (!($client instanceof SocketInterface) || get_resource_type($client->getResource()) !== 'Socket') {
        $client = getNewPlayer($server);
        continue;
    }

    if ($number === 0) {
        $number = random_int(1, 10);
        $userAttempt = 0;
        echo '-==New Game==-' . PHP_EOL;
        echo 'Number: ' . $number . PHP_EOL;
    }

    try {
        $msg = strtolower(trim($client->read(4, PHP_NORMAL_READ)));
    } catch (SocketException $e) {
        echo $e->getMessage() . PHP_EOL;
        continue;
    }

    echo 'Client message: ' . $msg . PHP_EOL;

    if ($msg === 'exit' || (int) $msg === $number) {
        $answer = is_numeric($msg) ? 'Congratulations! You got it! Bye.' . PHP_EOL : 'Thx for coming! Bye.' . PHP_EOL;
        $client = closeSocket($client, $answer);
        $number = 0;
        continue;
    }

    if ($msg < 1 || $msg > 10) {
        $client->write('Invalid input! Please, enter a number from 1 to 10.' . PHP_EOL);
        continue;
    }

    $userAttempt++;

    if ($userAttempt === ALLOW_USER_ATTEMPTS) {
        $client = closeSocket($client, 'Unfortunately, you did not guess the number :( Bye.' . PHP_EOL);
        $number = 0;
        continue;
    }

    $client->write(($msg < $number) ? 'Sorry, guess again but higher.'.PHP_EOL : 'Sorry, guess again but lower.'.PHP_EOL);
}

if ($client instanceof SocketInterface) {
    $client = closeSocket($client, 'Sorry, but we have to finish the game :( Bye.' . PHP_EOL);
}

$server->close();