<?php
/**
* Socket client work example
*
* @author Evgeny Prokhorov <contact@jekys.ru>
*/
require_once "conf.php";

use Jekys\Text as Txt;

$client = new Jekys\Socket($host, $port);
$serverMsg = null;

while ($serverMsg != 'Bye bye!') {
    $serverMsg = $client->readMsg();

    echo Txt::yellow('Server: ').$serverMsg.PHP_EOL;
    echo Txt::green('Client: ');

    $msg = readline();
    $client->sendMsg($msg);
}
