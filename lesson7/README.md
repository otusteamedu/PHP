# Simple smtp e-mail verifier

Simple smtp e-mail verifier is a PHP library for verify e-mails.

## Installation

```bash
git clone https://github.com/lenniDespero/simple-php-otus-email-verifier.git projectFolder
cd projectFolder
composer install
```

## Usage

```php
<?php

use Otus\Lessons\Lesson7\Verifier;

$someMails  = [
    '12345@mail.ru',
    '12345@yandex.ru',
    'some_strange.mail.From19984@domain.local'
];

$verifier = new Verifier();  // or $verifier = new Verifier($someMails)

$verifier->addMails($someMails);    // ["12345@mail.ru", "12345@yandex.ru", "example@example.com", "some_strange.mail.From19984@domain.local"]

$verifier->verify();

$verifier->getResult(); // ["12345@mail.ru" => ["checked"=>bool(true)],
                        //  "12345@mail.ru" => ["checked"=>bool(false), "error"=>"Fail: No mail <12345@yandex.ru> in mx.yandex.ru"],
                        //  "some_strange.mail.From19984@domain.local" => ["checked"=>bool(false), "error"=>"Fail: No MX from Domain 'domain.local'"]]
```

More examples in Example folder