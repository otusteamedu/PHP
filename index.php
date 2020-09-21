<?php

require 'bootstrap/app.php';
$dotenv = Dotenv\Dotenv::createUnsafeImmutable($_SERVER['DOCUMENT_ROOT']);
$dotenv->load();

\Core\Route::start();