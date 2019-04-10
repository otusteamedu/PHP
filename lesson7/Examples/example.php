<?php

require __DIR__ . DIRECTORY_SEPARATOR . '../vendor/autoload.php';

use Otus\Lessons\Lesson7\Verifier;

$someMails  = [
    '12345@mail.ru',
    '12345@yandex.ru',
    'some_strange.mail.From19984@domain.local'
];

$verifier = new Verifier();

$verifier->addMails($someMails);    // ["12345@mail.ru", "12345@yandex.ru", "example@example.com", "some_strange.mail.From19984@domain.local"]

$verifier->removeMails('example@example.com');  // ["12345@mail.ru", "12345@yandex.ru", "some_strange.mail.From19984@domain.local"]

$verifier->addMails('example@example.com'); // ["12345@mail.ru", "12345@yandex.ru", "some_strange.mail.From19984@domain.local", "example@example.com"]

$verifier->addMails('example@example.com'); // ["12345@mail.ru", "12345@yandex.ru", "some_strange.mail.From19984@domain.local", "example@example.com"]

$verifier->getMails();  // ["12345@mail.ru", "12345@yandex.ru", "some_strange.mail.From19984@domain.local", "example@example.com"]

$verifier->verify();

$verifier->getResult(); // ["12345@mail.ru" => ["checked"=>bool(true)],
                        //  "12345@mail.ru" => ["checked"=>bool(false), "error"=>"Fail: No mail <12345@yandex.ru> in mx.yandex.ru"],
                        //  "some_strange.mail.From19984@domain.local" => ["checked"=>bool(false), "error"=>"Fail: No MX from Domain 'domain.local'"]]

