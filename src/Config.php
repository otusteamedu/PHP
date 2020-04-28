<?php

namespace rudin\otus11;

class Config {
	public static function getParam($name) {
		$params = parse_ini_file("db.ini");
		if(isset($params[$name])) 
			return $params[$name]; 
		else 
			return "";
	}

	public static function getParams($names) {
		$params = parse_ini_file("db.ini");
		$result = [];
		foreach($names as $name) {
			if(isset($params[$name])) {
				$result[$name] = $params[$name];
			} else {
				$result[$name] = "";
			}
		}
		return $result;
	}
}