<?php

use Otus\Http\ChannelController;
use Otus\Http\Route;
use Otus\Http\StatisticsController;

return [
    Route::post('/channels', [ChannelController::class, 'store']),
    Route::get('/channels', [ChannelController::class, 'show']),
    Route::delete('/channels', [ChannelController::class, 'delete']),
    Route::get('/statistics', [StatisticsController::class, 'index']),
];
