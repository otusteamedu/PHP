<?php
// No Timeout
set_time_limit(0);
include_once 'transport.php';

$sock = new Transport('/tmp/server.sock');
echo "Готов принимать сообщения...\n";
while ( true ) {
	try {
		echo $sock->read_message();
	}
	catch ( Exception $e ) {
			echo $ex->getMessage();
		}
}

