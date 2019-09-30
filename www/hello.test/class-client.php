<?php
class Client
{
	private $client;

	private $address;

	private $accept;

	public function __construct() {
		$this->address = 'unix:///tmp/test.sock';
	}

	public function create_client() {
		$this->client = stream_socket_client($this->address, $errno, $errstr);
		if ( !$this->client ) {
			throw new Exception('Не могу создать клиента ' . $errno . ' ' . $errstr);
		}
	}

	public function send_message( $message ) {
		try {
			$sent = fwrite($this->client, $message);
			if ( !$sent ) {
				throw new Exception('Не могу отправить сообщение');
			} else {
				return 'Отправлено';
			}
		}
		catch ( Exception $e ) {
			echo $e->getMessage() . PHP_EOL;
		}
	}
}