#!/usr/bin/env php
<?php

$errno = null;
$errstr = null;

while(true)
{
  $client = @stream_socket_client("unix://" . __DIR__ . "/socket", $errno, $errstr);
  //$client = @stream_socket_client("tcp://127.0.0.1:4445", $errno, $errstr, 5);
  if($client)
  {
    $rc = fwrite($client, "Hi!\n");
    $read = fread($client, 4096);
    print "> $read.\n";
    fclose($client);
  }

  sleep(5);
}
