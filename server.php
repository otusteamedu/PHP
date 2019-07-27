#!/usr/bin/env php
<?php

function s_accept($socket, $timeout = 1)
{
  $client = stream_socket_accept($socket, $timeout);
  if(!$client)
  {
    return null;
  }

  if(false === stream_set_blocking($client, false))
  {
    throw new \RuntimeException("Unable to unblock stream!");
  }

  return $client;
}

$errno = null;
$errstr = null;
$server = stream_socket_server("unix://" . __DIR__ . "/socket", $errno, $errstr);
//$server = stream_socket_server("tcp://0.0.0.0:4445", $errno, $errstr);

$shutdown = function(...$args)
use(&$server)
{
  error_log("Shutting down.");

  if(false === fclose($server))
  {
    error_log("WTF?");
  }

  if(false === unlink(__DIR__ . "/socket"))
  {
    error_log("WTF?");
  }
};

register_shutdown_function($shutdown);

if(function_exists("pcntl_signal"))
{
  pcntl_signal(SIGINT, $shutdown);
}

$timeout = 0;
$rack = [];
$buffer = [];
while(true)
{
  $read = $rack;
  $read[] = $server;

  stream_select($read, $write, $except, 0, 200000);

  foreach($read as $stream)
  {
    if($stream === $server)
    {
      if($stream = s_accept($stream, 0))
      {
        $rack[] = $stream;
      }
      else
      {
        error_log("Failed to accept client.");
        continue;
      }
    }

    $id = array_search($stream, $rack);

    $s = (isset($buffer[$id]) ? $buffer[$id] : "") . stream_get_contents($stream);
    while(true)
    {
      $delim = strpos($s, "\n");
      if(false === $delim)
      {
        $buffer[$id] = $s;
        break;
      }

      [$head, $tail] = explode("\n", $s, 2);

      if(strlen($head))
      {
        print "$id: $head\n";
        if(false === fwrite($stream, "Ok\n"))
        {
          error_log("Broken stream $id, client dropped?");
        }
      }

      $s = $tail;
    }

    $buffer[$id] = $s;

    if(feof($stream))
    {
      error_log("EOF on stream $id, killing.");
      fclose($stream);
      unset($rack[$id], $buffer[$id]);
      continue;
    }
  }
}
