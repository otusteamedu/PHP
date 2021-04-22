<?php

namespace Otus\Sockets;

class Client
{

	public $socket;

	public function __construct(string $socketPath)
	{
		$this->initSocket($socketPath);
	}

	public function waitForMessage()
	{
		echo 'Client Message:';
		$this->message($this->readline());
	}

	public function message(string $message)
	{
		$this->socket->write($message);
		$this->waitingResponse();
	}

	public function initSocket(string $socketPath): void
	{
		$this->socket = new Socket($socketPath);
		$this->socket->create();
		$this->socket->connect();
	}

	public function readline(): string
	{
		return rtrim(fgets(STDIN));
	}

	public function waitingResponse()
	{
		echo "Server reply:\t" . $this->socket->read() . "\n";
	}
}
