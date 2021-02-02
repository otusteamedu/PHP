<?php

namespace Otus;

use Otus\Sockets\Client;
use Otus\Sockets\Server;

class App
{
	public function __construct()
	{
		$config = new Config();
		$config->get();
	}

	public function run()
	{
		if (isset($_SERVER['argv']) && !empty($_SERVER['argv'])) {
			$argv = $_SERVER['argv'];
			if ($argv[1] == 'server') {
				$server = new Server($_ENV['SOCKET_PATH']);
				$server->listen();
			} elseif ($argv[1] == 'client') {
				$client = new Client($_ENV['SOCKET_PATH']);
				$client->waitForMessage();
			} else {
				throw new \Exception('Wrong arguments!');
			}
		} else {
			throw new \Exception('No arguments!');
		}
	}
}
