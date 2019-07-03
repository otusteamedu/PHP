<?php

require __DIR__ . '/vendor/autoload.php';

use SMTPValidateEmail\Validator as SmtpEmailValidator;

/**
 * Simple example
 */
echo 'Enter email :' . PHP_EOL;
$email = fgets(STDIN);
$email = trim($email);
if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $sender = 'la-verne@yandex.ru';
    $validator = new SmtpEmailValidator($email, $sender);

// If debug mode is turned on, logged data is printed as it happens:
// $validator->debug = true;
    $results = $validator->validate();

    var_dump($results);
    // Get log data (log data is always collected)
    $log = $validator->getLog();
    var_dump($log);
} else {
    echo "E-mail адрес '$email' указан неверно.\n";
}

