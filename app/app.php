<?php

$shortopts = 'c:';
$longopts = [
    "command:",
];

$options = getopt($shortopts, $longopts);
$command = $options['c'] ?? ($options['command'] ?? '');

echo $command.PHP_EOL;
