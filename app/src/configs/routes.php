<?php

return [
    '/api/v1/homePost' => [
        'method' => ['POST'], // Обработка только POST-запросов
        'action' => 'HomeController@index' // Какой метод контроллера будет запускаться
    ],
    '/api/v1/homeGet' => [
        'method' => ['GET'],
        'action' => 'HomeController@index',
    ],
];
