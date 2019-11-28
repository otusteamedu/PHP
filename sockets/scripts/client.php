<?php
require_once "../Client.php";

$config = parse_ini_file("../config.ini");

$client = new Client($config["domain"], $config["type"], $config["protocol"]);

$client->initClientSocket($config["domainSocket"]);
$client->sendMsgToServer("Hi, server!!!");
$client->receiveMsgFromServer();
$client->closeSocket();
