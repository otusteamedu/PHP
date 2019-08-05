<?php

namespace crazydope\theater\Middleware;

use crazydope\theater\Model\User;
use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;

class ApiVerification implements IMiddleware
{
    public function handle(Request $request): void
    {
        // Do authentication
        $header = $request->getHeader('http-x-api-key');

        if ($header === null) {
            throw new \Exception('Unauthorized', 401);
        }

        if (password_verify(User::ROLE_GUEST, $header)) {
            $request->user = new User(['ApiController@show', 'ApiController@store']);
        }

        if (password_verify(User::ROLE_MANAGER, $header)) {
            $request->user = new User(['ApiController@index', 'ApiController@update', 'ApiController@destroy']);
        }

    }
}