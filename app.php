<?php

require("vendor/autoload.php");

use rudin\otus11\DataMapper\UsersMapper;




$userMapper = new UsersMapper();
$user = $userMapper->findById(3);

print_r($user->getFullData());

echo "Roles:\n";
$user->printRoles();