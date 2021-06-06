<?php


use App\Controllers\FilmController;
use App\Controllers\FilmReportController;
use App\Controllers\HomeController;
use App\Core\Request;

return [
    Request::GET_METHOD => [
        '/' => [HomeController::class, 'index'],
        '/films' => [FilmController::class, 'index'],
        '/films/show' => [FilmController::class, 'show'],
        '/films/create' => [FilmController::class, 'create'],
        '/films/edit' => [FilmController::class, 'edit'],
        '/films/delete' => [FilmController::class, 'delete'],
        '/films/report/success' => [FilmReportController::class, 'success'],
        '/films/report' => [FilmReportController::class, 'show'],
    ],
    Request::POST_METHOD => [
        '/films/report' => [FilmReportController::class, 'store'],
        '/films/update' => [FilmController::class, 'update'],
        '/films' => [FilmController::class, 'store'],
    ]
];