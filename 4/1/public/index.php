<?php
require '../vendor/autoload.php';

use Otus\App;

try {
	$app = new App($_POST);
} catch (Exception $e) {
	echo $e->getMessage();
}
