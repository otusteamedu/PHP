<?php
require '../vendor/autoload.php';

use Otus\App;

try {
	$emails = [
		'yurban1717@gmail.com',
		'yurban1717@gmail',
		'yurban1717@gmaissl.com',
	];
	$app = new App();
	$app->run($emails);
} catch (Exception $e) {
	echo $e->getMessage();
}
