<?php
require '../vendor/autoload.php';

use Otus\App;

try {
	if (isset($_POST['string'])) {
		$string = $_POST['string'];
		$app = new App($string);
	} else {
		throw new Exception('Передайте строку с помощью post!');
	}
} catch (Exception $e) {
	echo $e->getMessage();
}