<?php

use Symfony\Component\Dotenv\Dotenv;

$env = include_once(__DIR__ . '/config/env.php');

(new Dotenv())->load($env['dir']);
