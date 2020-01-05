<?php
require("Server.php");

$server = new Server("config.ini");
$server->start();
