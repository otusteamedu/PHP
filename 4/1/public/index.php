<?php
require '../src/Otus/App.php';

try {
	$_POST = ['string' => '(l)()'];
	$app = new App($_POST);
} catch (Exception $e) {
	echo $e->getMessage();
}
