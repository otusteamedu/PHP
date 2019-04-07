#!/usr/bin/php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use \Chatbot\{ChatClient, ChatServer};

$address = '127.0.0.1';
$port = 10000;

$shortopts = "s::";
$shortopts .= "h::";

$longopts  = array(
    "server::",
    "help::",
);

$options = getopt($shortopts, $longopts);

if (array_key_exists("h", $options) || array_key_exists("help", $options)) { 
    echo "Help" . PHP_EOL . "----------------- " . PHP_EOL . " quit - exit from server" . PHP_EOL . " close - server shutdown " . PHP_EOL . " -s - start chat server" . PHP_EOL; 
    die; 
}

if (array_key_exists("s", $options) || array_key_exists("server", $options)) {
    // Start Chat Server
    $chatObj = new ChatServer($address, $port);
    $chatObj->server();
} else {
    // Start client
    $chatObj = new ChatClient($address, $port);
    $chatObj->client();
}
