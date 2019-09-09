<?php
require_once 'vendor/autoload.php';
//phpinfo();
$db = new \MongoDB\Client();
var_dump($db->listDatabases());