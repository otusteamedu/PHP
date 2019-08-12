<?php

$pathSocket = __DIR__ . "/test.sock";

if (file_exists($pathSocket))
{
    unlink($pathSocket);
}

$socket = stream_socket_server(
    "unix://" . $pathSocket,
    $errno,
    $errstr
);

if (!$socket)
{
    echo "$errstr ( $errno )\n";
}
else
{
    while ( $conn = stream_socket_accept($socket) )
    {
        $message= fread($conn, 1024);
        echo 'I have received that : ' . $message . PHP_EOL;
        $data = "Московское время" . date("H:i:s")  . PHP_EOL;
        fwrite( $conn, $data );
        fclose( $conn );
    }
    fclose($socket);
}

