<?php
require '../vendor/autoload.php';

use Otus\App;

try {
	$app = new App();
	if (is_file($_ENV['EMAILS_PATH'])) {
		$emails = explode("\n", file_get_contents($_ENV['EMAILS_PATH']));
		foreach ($emails as $email) {
			if (!$app->verifyEmail($email)) {
				echo $app->message;
			} else {
				echo 'Email "' . $email . '" - is valid!<br>';
			}
		}
	} else {
		throw new Exception('emails file not found!' . $_ENV['EMAILS_PATH']);
	}
} catch (Exception $e) {
	echo $e->getMessage();
}
