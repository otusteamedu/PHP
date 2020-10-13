<?php
$sockAddr = 'unix:///tmp/socket.sock';
//$sock = stream_socket_client(, $errno, $errstr);
$sock = stream_socket_server($sockAddr,$errno, $errstr);

if (!$sock) {
    die(sprintf("Error: %s (%s)", $errstr, $errno));
} else {
    echo "created socket \n";
}
stream_set_blocking($sock,0);
while ($conn = stream_socket_accept($sock)) {
    echo "Write \n";
    fwrite($conn, 'SOME2 COMMAND2' . "\r\n");
    echo "close connection \n";
    fclose($conn);
}

//echo fread($sock, 4096)."\n";

echo "close socket \n";
fclose($sock);

echo "done\n";