<?php

require 'vendor/autoload.php';

$cfg = new Deadly117\Config('config.ini');
echo $cfg->getValue('socket.file'), PHP_EOL;
var_dump($cfg);