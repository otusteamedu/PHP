<?php

namespace Model;

class Connection
{
	private $connect;

	public function __construct() {
		$this->connect = new \PDO('pgsql:host=localhost; dbname=cinema', 'cinema', 'qweasd');
	}

	public function make() {
		return $this->connect;
	}
}
