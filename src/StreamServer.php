<?php

namespace AnrDaemon\Net;

class StreamServer
{
  protected $uri;
  protected $errno;
  protected $errstr;
  protected $flags;
  protected $context;

  protected $connectTimeout;
  protected $readTimeout;

  protected $server;
  protected $fallback;
  protected $handlers = [];

  protected function init()
  {
    $context = $this->context ?: stream_context_create();

    $this->server = stream_socket_server($this->uri, $this->errno, $this->errstr, $this->flags, $context);
    if(false === $this->server)
    {
      throw new \RuntimeException("Unable to start server: " . error_get_last()["message"]);
    }
  }

  protected function accept($socket)
  {
    $client = stream_socket_accept($socket, $this->connectTimeout);
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

  protected function dispatch($verb)
  {
    return isset($this->handlers["k:$verb"]) ? $this->handlers["k:$verb"] : $this->fallback;
  }

  public function stop()
  {
    if(is_resource($this->server))
    {
      if(false === fclose($this->server))
      {
        error_log("Error occured while closing server socket.");
      }

      [$shema, $path] = explode(":", $this->uri, 2);
      if($shema === "unix" && false === unlink($path))
      {
        error_log("Error occured while removing socket file.");
      }
    }
  }

  public function start()
  {
    $this->init();

    $rack = [];
    $buffer = [];
    while(true)
    {
      $read = $rack;
      $read[] = $this->server;

      stream_select($read, $write, $except, 0, 200000);

      foreach($read as $stream)
      {
        if($stream === $this->server)
        {
          if($stream = $this->accept($stream, 0))
          {
            $rack[] = $stream;
          }
          else
          {
            error_log("Failed to accept client.");
            continue;
          }
        }

        $id = array_search($stream, $rack, true);

        $s = (isset($buffer[$id]) ? $buffer[$id] : "") . stream_get_contents($stream);
        while(true)
        {
          $delim = strpos($s, "\n");
          if(false === $delim)
          {
            break;
          }

          [$head, $tail] = explode("\n", $s, 2);
          $verb = trim($head);
          if(strlen($verb))
          {
            print "$id: $verb\n";
            $handler = $this->dispatch($verb);
            $response = $handler($verb);
            if(false === fwrite($stream, "$response\n"))
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
  }

  public function setHandler(string $verb, callable $handler)
  {
    if(is_resource($this->server))
    {
      throw new \BadMethodCallException("Unable to redefine handlers while server is running");
    }

    if($verb === "DEFAULT")
    {
      $this->fallback = $handler;
    }
    else
    {
      $this->handlers["k:$verb"] = $handler;
    }
  }

  public function setFlags(int $flags)
  {
    $this->flags = $flags;
  }

  public function setContext(resource $context)
  {
    $this->context = $context;
  }

  public function setConnectTimeout(int $timeout)
  {
    $this->connectTimeout = $timeout;
  }

  public function setReadTimeout(int $timeout)
  {
    $this->readTimeout = $timeout;
  }

  public function __construct(string $uri, int $flags = STREAM_SERVER_BIND | STREAM_SERVER_LISTEN, resource $context = null)
  {
    $this->uri = $uri;
    $this->flags = $flags;
    $this->context = $context;
    $this->connectTimeout = ini_get("default_socket_timeout");
    $this->readTimeout = ini_get("default_socket_timeout");
  }

  public function __destruct()
  {
    if(is_resource($this->server))
    {
      error_log("Shutting down.");
      $this->stop();
    }
  }

  public function __clone()
  {
    if(is_resource($this->server))
    {
      throw new \BadMethodCallException("Unable to clone running server instance");
    }
  }

  public function __sleep()
  {
    if(is_resource($this->server))
    {
      throw new \BadMethodCallException("Unable to serialize running server instance");
    }
  }
}
