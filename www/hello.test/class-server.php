<?php
class Server
{
	private $server;

	private $file;

	private $address;

	public function __construct() {
		$this->file = '/tmp/test.sock';
		$this->address = 'unix:///tmp/test.sock';
	}

	public function create_server() {
		if ( file_exists( $this->file ) ) {
			unlink($this->file);
		}
		$this->server = stream_socket_server($this->address, $errno, $errstr);
		if ( !$this->server ) {
			throw new Exception('Не могу создать сокет ' . $errno . ' ' . $errstr);
		}
	}

	private function accept_socket() {
		$accept = stream_socket_accept($this->server, -1);
		if ( !$accept ) {
			throw new Exception('Не могу подключиться');
			return null;
		} else {
			return $accept;
		}
	}

	public function read_message() {
		try {
			$accept = $this->accept_socket();
		}
		catch ( Exception $e ) {
			echo $e->getMessage() . PHP_EOL;
		}

		$buf = fread($accept, 1024);
		if ( $buf ) {
			return "Получено: $buf \n";
		}

		return null;
	}


}