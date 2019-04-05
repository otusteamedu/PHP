<?php 
    if (empty($_POST)) {
	header('HTTP/1.1 500 Internal Server Error');
	echo "The POST required";
    } elseif (isset($_POST['string']) && $_POST['string'] == '(()()()()))((((()()()))(()()()(((()))))))') {
	header('HTTP/1.1 200 OK');
	echo "OK";
    } else {
	header('HTTP/1.1 400 Bad Request');
	echo "Bad request";
    }
