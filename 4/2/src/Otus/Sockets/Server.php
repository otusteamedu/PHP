<?php

namespace Otus\Sockets;

class Server
{
	public $socket;

	public function __construct(string $socketPath)
	{
		$this->initSocket($socketPath);
	}

	public function listen()
	{
		echo "Listen server...\n\n";
		do {
			$this->socket->accept();

			$message = $this->socket->readFromAccepted();

			if ($message === 'close') {
				break;
			}
			echo "Client message:\t" . $message . "\n";

			echo "Enter your message:\t";
			$reply = $this->readline();
			$this->socket->writeToAccepted($reply);
		} while (true);

		$this->socket->close();
	}

	public function initSocket(string $socketPath): void
	{
		$this->socket = new Socket($socketPath);
		$this->socket->clearOldSocket();
		$this->socket->create();
		$this->socket->bind();
		$this->socket->listen();
	}

	public function readline(): string
	{
		return rtrim(fgets(STDIN));
	}

}
