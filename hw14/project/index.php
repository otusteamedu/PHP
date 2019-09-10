<?php
require_once 'vendor/autoload.php';
//phpinfo();
$db = new \MongoDB\Client('mongodb://mongodb', ['username'=>'test','password'=>'qwerty']);
var_dump($db->listDatabases());