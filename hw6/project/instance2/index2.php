<?php
declare(strict_types=1);

require_once "/var/www/project/init.php";
$mailsForCheck = [
    'dfcjnfd',
    'jmdf@mdfkjdkjdv.dc',
    'kjncn@mail.ru',
    'kjncfnjk@gmail.com',
];
$checkResults = [];
$checker = new MailChecker();
foreach ($mailsForCheck as $mail) {
    $resultCheck = $checker->checkMail($mail) ? 'valid 2' : 'not valid 2';
    $checkResults[$mail] = $resultCheck;
}

foreach ($checkResults as $mail => $result) {
    echo "$mail - $result</br>";
}
