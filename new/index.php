<?php

if($_SERVER['SERVER_PORT'] != 443) {
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
    exit();
};

require("config.php");

$f3->route("GET|POST /api/@method", "api->@method");
$f3->route("GET /", "main->index");
// $f3->route("GET /company/@id", "main->company");
$f3->route("GET /login", "secure->login");
$f3->route("POST /login", "secure->login_action");

$f3->route("GET /c/@id", "main->company");

$f3->run();