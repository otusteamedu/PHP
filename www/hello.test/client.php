<?php
// No Timeout
set_time_limit(0);
include_once 'class-client.php';

$sock = new Client();

	try {
		// Получаем первый параметр из командной строки для передачи на сервер
		$message = $argv[1];
		if ( !$message ) {
			throw new Exception('Вы ничего не передали');
		}
		$sock->create_client();
		echo $sock->send_message($message) . PHP_EOL;

	}
	catch ( Exception $e ) {
			echo $e->getMessage() . PHP_EOL;
	}


