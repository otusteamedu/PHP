<?php

require("vendor/autoload.php");

use rudin\otus11\DataMapper\UsersMapper;
use rudin\otus11\Entities\User;



$user = new User(0, "rudin", "rudinandrey@yandex.ru", "12345678");

$usersMapper = new UsersMapper();

try {
	$c = $usersMapper->create($user);
	echo "Пользователь успешно создан\t".$c."\n";
} catch(Exception $e) {
	echo $e->getMessage();
}


