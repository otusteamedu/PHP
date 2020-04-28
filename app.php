<?php

require("vendor/autoload.php");

use rudin\otus11\DataMapper\UsersMapper;
use rudin\otus11\Entities\User;

$options = getopt("", ["id:", "help", "list", "create:"]);

try {
	
	if(isset($options["id"])) {
		$userMapper = new UsersMapper();
		$user = $userMapper->findById($options["id"]);
		$userData = $user->getFullData();
		echo "Имя: ".$userData["name"]."\n";
		echo "Email:".$userData["email"]."\n";
		echo "Roles:\n";
		$user->printRoles();
	}

	if(isset($options["list"])) {
		$usersMapper = new UsersMapper();
		$users = $usersMapper->getListUsers();
		echo "id\tname\n";
		foreach($users as $user) {
			echo $user["id"]."\t".$user["name"]."\n";
		}
	}

	if(isset($options["help"])) {
		echo "--help Эта справка\n";
		echo "--id=XX получить данные пользователя с ID=XX\n";
		echo "--list получить список всех пользователей с идентификаторами\n";
		echo "--create=name,email,password создание нового пользователя\n";
	}

	if(isset($options["create"])) {
		$usersMapper = new UsersMapper();
		$userFields = array_map(function($el){ return trim($el); }, explode(",", $options["create"]));
		
		$user = new User(0, $userFields[0], $userFields[1], $userFields[2]);
		$c = $usersMapper->create($user);
		if($c == 1) {
			echo "Пользователь успешно создан\n";
		} else {
			echo "Пользователь не создан, проверьте входные параметры\n";
		}
	}

	
} catch(Exception $e) {
	echo $e->getMessage();
}

