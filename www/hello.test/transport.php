<?php
class Transport
{

	private $socket;

	private $file;

	public function __construct( $file ) {
		$this->file = $file;
		@unlink($this->file);

		try {
			$this->create_socket();
			$this->bind_socket();
		}
		catch ( Exception $e ) {
			echo $ex->getMessage();
		}

	}

	private function create_socket() {
		$this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
		if ( !$this->socket ) {
			throw new Exception('Не могу создать сокет');
		}
	}

	private function bind_socket() {
		if ( !socket_bind($this->socket, $this->file) ) {
			throw new Exception('Не могу подключиться');
		}
		socket_listen($this->socket);
	}

	private function connect_socket() {
		if ( !socket_connect($this->socket, $this->file) ) {
			throw new Exception('Не могу подключиться');
		}
	}

	public function send_message( $message ) {
		if ( !socket_set_nonblock($this->socket) ) {
			throw new Exception('Не могу установить неблокирующий режим');
		}
		$connection = socket_accept($this->socket);
		$len = strlen($message);
		$sent = socket_write($connection, $message);
		if ( !$sent ) {
			throw new Exception('Не могу отправить сообщение');
		} else {
			return 'Отправлено';
		}
	}

	public function read_message() {
		$this->connect_socket();
		$buf = socket_read($this->socket, 1024);
		if ( $buf ) {
			return "Получено: $buf \n";
		} else {
				throw new Exception('Не могу получить сообщение');
		}
	}
}