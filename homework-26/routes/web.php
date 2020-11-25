<?php

use Otus\Http\QueueController;
use Otus\Http\Route;

return [
    Route::post('/queue', [QueueController::class, 'store']),
];
