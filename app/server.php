<?php

require_once(__DIR__ . '/vendor/autoload.php');
require_once(__DIR__ . '/Server/Server.php');
define('STOP' , 'stop');

use Marchenko\Config as Config;

$config = new Config("config.ini");
try {
  $server = new Server($config->get("server_socket"));
  while (true) {
    $value = $server->read();
    echo "Received: " . $value . PHP_EOL;
    if (strtolower($value) == STOP) {
      break;
    }
  }
}
catch (Exception $e) {
  echo $e->getMessage() . "\n";
}



