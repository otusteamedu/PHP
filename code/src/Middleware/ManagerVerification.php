<?php

namespace crazydope\theater\Middleware;

use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;

class ManagerVerification implements IMiddleware
{
    public function handle(Request $request): void
    {
        // Do authentication
        if ($request->getUser() === null) {
            response()->auth('admin');
        }

        if ($request->getUser() !== getenv('API_ADMIN_USER') || $request->getPassword() !== getenv('API_ADMIN_PASSWORD')) {
            response()->auth('admin');
        }
    }
}