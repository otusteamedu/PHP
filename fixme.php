<?php

require 'vendor/autoload.php';

$input = trim($argv[1]);

$fixCommand = new \lexerom\FixCommand($input);
$fixCommand->execute();