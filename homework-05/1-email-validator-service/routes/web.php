<?php

use Otus\Http\Controller;
use Otus\Http\Route;

return [
    Route::post('/', [Controller::class, 'index']),
];
