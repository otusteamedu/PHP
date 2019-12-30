<?php

require 'vendor/autoload.php';

if (PHP_SAPI !== 'cli') {
    echo 'Сервер должен был запущен в консольном режиме.';
    echo PHP_EOL;
}

set_time_limit (0);
ob_implicit_flush ();

//$factory = new \Socket\Raw\Factory();
//$socket = $factory->createClient('unix:///socket/socket.sock');

$socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
if (!$socket) {
    exit('Unable to create socket.');
}

$socketFile = "/socket/app.sock";

if (!socket_bind($socket, $socketFile)) {
    exit("Unable to bind to $socketFile");
}

socket_close($socket);
unlink($socketFile);



//socket_sendto($socket, "Hello World!", 12, 0, "/socket/app.sock", 0);
//echo "sent\n";