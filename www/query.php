<?php

require_once('vendor/autoload.php');

if ( $_POST && isset( $_POST['string'] ) && $_POST['string'] ) {
	$result = ( new \MyValidator\Validator( $_POST['string'] ) )->validate();
	echo $result;
} else {
	echo 0;
}


