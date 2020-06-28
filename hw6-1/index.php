<?php

include_once('vendor/autoload.php');

$v = new \Classes\Validator();

echo ($v->isCorrect('(()())'))
    ? 'correctly'
    : 'incorrectly';

