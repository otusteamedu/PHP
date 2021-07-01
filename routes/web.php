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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/channel', [App\Http\Controllers\ChannelController::class, 'index'])->name('home');
Route::get('/channel/top', [App\Http\Controllers\ChannelController::class, 'top'])->name('home');
Route::get('/channel/create', [App\Http\Controllers\ChannelController::class, 'create'])->name('home');
Route::get('/channel/delete', [App\Http\Controllers\ChannelController::class, 'delete'])->name('home');
Route::get('/channel/update', [App\Http\Controllers\ChannelController::class, 'update'])->name('home');
Route::get('/channels/{channel}', [
    \App\Http\Controllers\ChannelController::class,
    'show',
])->name('channels.show');
Route::get('/videos/{video}', [
    \App\Http\Controllers\ChannelController::class,
    'show',
])->name('videos.show');
