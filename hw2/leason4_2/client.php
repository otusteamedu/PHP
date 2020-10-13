<?php
$sock = stream_socket_client('unix:///tmp/socket.sock', $errno, $errstr);

if (!$sock) {
    die(sprintf('Error: %s (%s)', $errstr, $errno));
} else {
    echo "client connected \n";
}
//fwrite($sock, 'SOME COMMAND'."\r\n");
while (!feof($sock)) {
    $data = fread($sock, 4096);
    print_r($data);
}

fclose($sock);
