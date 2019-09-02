#!/usr/bin/env php
<?php

namespace AnrDaemon;

require __DIR__ . "/src/classloader.php";

$uri = "unix://" . __DIR__ . "/socket";
//$uri = "tcp://0.0.0.0:4445";
$server = new Net\StreamServer($uri);

if(function_exists("pcntl_signal"))
{
  pcntl_signal(SIGINT, [$server, "stop"]);
}

$server->setHandler("DEFAULT", function($verb)
{
  return "Ok";
});

$server->start();
