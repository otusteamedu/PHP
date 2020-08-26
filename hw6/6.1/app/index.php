<?php
include_once __DIR__.'/vendor/autoload.php';

use App\App;

$emails = include 'emails.php';
(new App())->run($emails);
