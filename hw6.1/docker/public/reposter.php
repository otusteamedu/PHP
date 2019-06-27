<?php

$str = $_POST['string'];

if (!empty($str) && strlen($str) > 0) {
    http_response_code(200);
} else {
    http_response_code(400);
}
