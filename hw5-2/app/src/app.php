<?php

declare(strict_types=1);

namespace App;

class App
{

    public function run(): void
    {
        echo 'Nginx: ' . $_SERVER['SERVER_ADDR'] . '<br>';
        echo 'Php-fpm: ' . getHostByName(php_uname('n'));
    }

}
