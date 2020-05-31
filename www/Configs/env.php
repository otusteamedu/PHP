<?php

use Dotenv\Dotenv;

$env = Dotenv::createImmutable(dirname(dirname(__FILE__)));
$env->load();
