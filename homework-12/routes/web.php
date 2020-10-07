<?php

use Otus\Http\EventController;
use Otus\Http\Route;

return [
    Route::post('/events', [EventController::class, 'store']),
    Route::get('/events', [EventController::class, 'show']),
    Route::delete('/events', [EventController::class, 'delete']),
];
