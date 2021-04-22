<?php

namespace Otus\Sockets;

class Socket
{
	public $socket;
	public $acceptedSocket;
	public $connect;
	public $bind;
	public string $socketPath;

	public function __construct(string $socketPath)
	{
		$this->socketPath = $socketPath;
	}

	public function write(string $message): void
	{
		$this->writeToSocket($this->socket, $message);
	}

	public function writeToAccepted(string $message): void
	{
		$this->writeToSocket($this->acceptedSocket, $message);
	}

	public function clearOldSocket(): void
	{
		if (file_exists($this->socketPath)) {
			unlink($this->socketPath);
		}
	}

	public function create(): void
	{
		$this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
		if ($this->socket === false) {
			throw new \Exception('Error of creating socket');
		}
	}

	public function accept()
	{
		$this->acceptedSocket = socket_accept($this->socket);
		if ($this->acceptedSocket === false) {
			throw new \Exception('Error of accepting socket');
		}
	}

	public function bind(): void
	{
		$this->bind = socket_bind($this->socket, $this->socketPath);
		if ($this->bind === false) {
			throw new \Exception('Error of binding socket');
		}
	}

	public function connect(): void
	{
		$this->connect = socket_connect($this->socket, $this->socketPath);
		if ($this->connect === false) {
			throw new \Exception('Error of connect socket');
		}
	}

	public function listen(): void
	{
		$this->bind = socket_listen($this->socket);
		if ($this->bind === false) {
			throw new \Exception('Error of listening socket');
		}
	}

	public function close(): void
	{
		if (!$this->socket) {
			return;
		}
		socket_close($this->socket);
	}

	public function writeToSocket($socket, string $message): void
	{
		if (socket_write($socket, $message, strlen($message)) == false) {
			throw new \Exception('Socked Write failed!');
		}
	}

	public function read(): ?string
	{
		return $this->readFromSocket($this->socket);
	}

	public function readFromAccepted()
	{
		return $this->readFromSocket($this->acceptedSocket);
	}

	public function readFromSocket($socket): ?string
	{
		if (($buf = socket_read($socket, 1024)) === false) {
			throw new \Exception('Error of reading from socket');
		}
		if (!$buf = trim($buf)) {
			return null;
		}
		return trim($buf);
	}
}
