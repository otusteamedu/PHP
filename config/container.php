<?php

use Bjlag\App;
use Bjlag\Db\Store;

return [
    Store::class => function () {
        return App::getDb();
    },
];
