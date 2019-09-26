<?php
// No Timeout
set_time_limit(0);
include_once 'transport.php';

// Готовим параметры из командной строки для передачи на сервер
$opts = "";
$opts .= "f:";  // Required
$opts .= "s:";  // Required

$options = getopt( $opts );
$message = implode(' :: ', $options);

$sock = new Transport('/tmp/server.sock');

try {
	echo $sock->send_message( 'ура' );
}
catch ( Exception $e ) {
	echo $ex->getMessage();
}

