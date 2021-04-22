<?php


namespace Otus;

use Dotenv\Dotenv;

class Config
{
	public $config;

	public function get(){
		if (is_null($this->config)) {
			$dotenv = Dotenv::createImmutable(__DIR__ . '/../2/');
			$this->config = $dotenv->load();
		}
		return $this->config;
	}
}