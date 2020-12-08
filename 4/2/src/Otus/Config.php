<?php


namespace Otus;

use Dotenv\Dotenv;

class Config
{
	public $config;

	public function get(){
		if (is_null($this->config)) {
			$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
			$this->config = $dotenv->load();
		}
		return $this->config;
	}
}