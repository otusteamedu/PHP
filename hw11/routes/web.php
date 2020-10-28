<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/YouTube-spider', function() {
    return view('youtube.youspider');
});

Route::post('/YouTube-spider/getInfo', [\App\Http\Controllers\youTubeSpiderController::class, 'getFromYouTubeLink']);

Route::get('/YouTubeStatistics', [\App\Http\Controllers\YouTubeStatisticController::class, 'index']);
Route::post('/YouTubeStatistics', [\App\Http\Controllers\YouTubeStatisticController::class, 'getChannelStatistics']);
Route::get('/YouTubeStatistics/Top', [\App\Http\Controllers\YouTubeStatisticController::class, 'getTopChannel']);
