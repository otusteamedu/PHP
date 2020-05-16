<?php

use Classes\Email\EmailCheckServiceImpl;
use Classes\Email\Validator\EmailValidatorsServiceImpl;

require_once 'vendor/autoload.php';

echo 'IP адрес текущего сервера:' . ($_SERVER['SERVER_ADDR']);
echo '<br/>';

$emails = [
    'test@test.ru',
    'test.ru',
    'test@gmail.com',
];

$emailCheckService = new EmailCheckServiceImpl(new EmailValidatorsServiceImpl(), $emails);
$emailCheckResponse = $emailCheckService->run();

echo $emailCheckResponse->responseMessage;
echo '<br/>';

if (!empty($emailCheckResponse->emailsCheckErrors)) {
    echo 'Ошибки:';
    echo '<br/>';
    echo implode(';<br>', $emailCheckResponse->emailsCheckErrors);
}
