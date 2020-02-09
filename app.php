<?php

require("config.php");
require("vendor/autoload.php");

$scanner = new Youtube\Scanner($api_key);

echo "Ok\n";
$channel = "UC_x5XG1OV2P6uZZ5FSM9Ttw";
$maxResults = 10;

$videos = $scanner->channels($channel);
print_r($videos);