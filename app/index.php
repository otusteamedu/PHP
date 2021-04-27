<?php

require_once(__DIR__ . '/vendor/autoload.php');

$shortopts = 't:c:';
$longopts = [
    "type:",
    "config:"
];
$options = getopt($shortopts, $longopts);
$type = $options['t'] ?? ($options['type'] ?? '');
$config = $options['c'] ?? ($options['config'] ?? '');

if (empty($type) || empty($config)) {
    echo "Please, checks arguments." . PHP_EOL;
    exit(0);
}

try {
    $app = new \Marchenko\App($type, $config);
    $app->run();
}
catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
