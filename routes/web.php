<?php

use App\Models\Channel;
use App\Services\Channels\Repositories\ChannelRepositoryInterface;
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

Route::get('/channels/spider', function (\App\Services\Channels\YoutubeChannelService $youtubeChannelService) {
    $youtubeChannelService->parseNew();
    return redirect('/channels');
});
Route::view('/channels', 'channels', ['channels' => Channel::all()->reverse()]);
Route::get('/channels/search', function (ChannelRepositoryInterface $repository) {
    return view('channels', ['channels' => $repository->search((string)request('q'))]);
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
