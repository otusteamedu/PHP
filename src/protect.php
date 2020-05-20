<?php

require_once __DIR__ . '/../vendor/autoload.php';

$data = [
    "message" => "Data with SQL-injection ' AND 0"
];

$data = \base\security\Security::protectData($data);

echo "protected data: {$data['message']}";