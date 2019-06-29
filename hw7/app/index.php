<?php
require_once "vendor/autoload.php";

$email = $_REQUEST['email'] ?? '';
$action = $_REQUEST['action'] ?? '';

$response = new App\Response($email, $action);
echo json_encode($response->get());
