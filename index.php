<?
require_once('./vendor/autoload.php');
$emailList = [
    'omen.ekb@gmail.com',
    'omen.ekb@gmail,com',
    'omen.ekb@yandex.ru',
    '1@1.ru',
    'testString',
    '11111@mail.ru'
];

$emailValidator = new classes\EmailValidator($emailList);
$emailValidator->validateEmail();
$emailValidatorErrors = $emailValidator->getErrors();
if (!empty($emailValidatorErrors)) {
    foreach ($emailValidatorErrors as $email => $error) {
        echo $email . ' -> ' . $error . PHP_EOL;
    }
}