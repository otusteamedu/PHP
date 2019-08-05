<?php

use crazydope\theater\Router;

Router::csrfVerifier(new \crazydope\theater\Middleware\CsrfVerifier());

Router::group(['namespace' => '\crazydope\theater\Controller'], static function () {
    Router::get('/', 'DefaultController@home')->setName('home');
    Router::get('/404', 'DefaultController@notFound')->setName('404');
    Router::get('/status/{id}', 'DefaultController@status',['defaultParameterRegex'=>
        '[0-9a-fA-F]{8}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{12}']);

    Router::get('/work', 'ManagerController@work',
        ['middleware'=>\crazydope\theater\Middleware\ManagerVerification::class])->setName('work');

    Router::group([
        'prefix' => '/api',
        'middleware'=>\crazydope\theater\Middleware\ApiVerification::class,
        'exceptionHandler'=>\crazydope\theater\Handlers\CustomExceptionHandler::class], static function () {
        Router::resource('/message','ApiController',['defaultParameterRegex'=>
            '[0-9a-fA-F]{8}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{12}']);
    });
});

