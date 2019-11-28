<?php
require_once "../Server.php";

$config = parse_ini_file("../config.ini");

$server = new Server($config["domain"], $config["type"], $config["protocol"]);

$server->initServerSocket($config["domainSocket"]);
$server->processedMsgFromClient();
$server->closeSocket();
