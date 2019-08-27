<?php
/**
* Socket server work example
*
* @author Evgeny Prokhorov <contact@jekys.ru>
*/
require_once "conf.php";

use Jekys\SocketServer as Server;

$server = new Server($host, $port);

$server->sendMsg('Who are you?');

$name =  $server->readMsg();
$server->sendMsg('Hello, '.$name.'! What do you want?');

$wish = $server->readMsg();

$answers = [
    'You will get it!',
    'Ahaha, ok',
    'No, it is impossible',
    'I hope it was a joke'
];

while (strtolower($wish) != 'no') {
    $msg = $answers[rand(0, count($answers) - 1)];
    $server->sendMsg($msg.' Anything else?');
    $wish = $server->readMsg();
}

$server->sendMsg('Bye bye!');
