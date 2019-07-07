<?php

require 'vendor/autoload.php';

use lexerom\Email\Validator as EmailValidator;
use lexerom\Email\Rule\{Dns, LocalPart, DomainName};

$email = $_GET['email'] ?? 'default@gmail.com';

$validator = new EmailValidator([
    new Dns(),
    new LocalPart(),
    new DomainName()
]);

$result = $validator->validate($email);

if ($result) {
	echo 'Email is valid';
} else {
	echo 'Email is invalid';
}