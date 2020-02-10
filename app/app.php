<?php

use App\BracketValidator;

require_once __DIR__ . '/vendor/autoload.php';

if(empty($_POST['query'])) {
    throw new InvalidArgumentException();
}

var_dump((new BracketValidator($_POST['query']))->validate());