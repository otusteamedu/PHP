<?php

namespace rudin\otus11\Entities;


class DB {
	public function __construct() {

	}

	public static function pdo() {
		return new \PDO("pgsql:dbname=test;host=small.crmit.ru", "db_test", "DBTest");
	}
}