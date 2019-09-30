<?php
// No Timeout
set_time_limit(0);
include_once 'class-server.php';

$sock = new Server();

try {
	$sock->create_server();

	while ( true ) {
		echo $sock->read_message();
	}

}
catch ( Exception $e ) {
	echo $e->getMessage() . PHP_EOL;
	exit;
}