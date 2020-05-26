<?php


require_once(__DIR__ . '/vendor/autoload.php');
require_once(__DIR__ . '/Client/Client.php');

use Marchenko\Config as Config;

$shortopts = 'v:';
$longopts = [
    "value:",
];
$options = getopt($shortopts, $longopts);
$value = $options['v'] ?? ($options['value'] ?? 'value');

$config = new Config("config.ini");
try {
  $client = new Client($config->get("server_socket"));
  $client->write($value);
}
catch (Exception $e) {
  echo $e->getMessage() . "\n";
}