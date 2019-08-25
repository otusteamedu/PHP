<?php

require_once __DIR__ . '/vendor/autoload.php';

use AsFuck\Analyser;
use AsFuck\CommandManager;

$options = getopt('a', ['command::']);
$command = $options['command'] ?? null;
$executionFlag = isset($options['a']) ? true : false;


if ($command) {
    $analyser = new Analyser($command);
    $result = $analyser->getProperComamnd();
    if ($result !== null) {
        CommandManager::saveCommandToRun($result);
        echo "Did you mean:" . PHP_EOL . $result . PHP_EOL;
    }
}

if ($executionFlag) {
    CommandManager::executeCommand();
}
