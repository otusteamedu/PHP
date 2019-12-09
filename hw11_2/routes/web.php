<?php

Route::get('/', 'HomeController@index')->name('home');

Route::group(['prefix' => 'event', 'as' => 'event.'], function () {
    Route::get('create', 'EventController@create')->name('create');
    Route::get('search', 'EventController@search')->name('search');
    Route::post('/', 'EventController@store')->name('store');
    Route::delete('clear', 'EventController@clear')->name('clear');
});
