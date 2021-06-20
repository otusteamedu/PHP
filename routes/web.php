<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    if (view()->exists('vendor.swagger-lume.index')) {
        return view('vendor.swagger-lume.index', ['urlToDocs' => '/api-doc/']);
    }
    return app()->version();
});

$router->get('/api-doc/', fn() => json_decode(file_get_contents(storage_path() . '/api-docs/api-docs.json'), true));