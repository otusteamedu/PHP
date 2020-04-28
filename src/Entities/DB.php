<?php

namespace rudin\otus11\Entities;


class DB {
	public static function pdo() {
		$connect = \rudin\otus11\Config::getParams(["host", "db", "username", "password"]);
		return new \PDO("pgsql:dbname={$connect["db"]};host={$connect["host"]}", $connect["username"], $connect["password"]);
	}
}