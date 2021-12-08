<?php

namespace App\Http\Controllers\Api\V1\Users;


use App\Http\Controllers\Controller;
use App\Services\Estate\EstateService;
use App\Services\Users\UserService;

class BaseUserController extends Controller
{
    const USERS_PER_PAGE = 25;
    const MAX_USERS_PER_PAGE = 100;

    protected function getUserService(): UserService
    {
        return app(UserService::class);
    }

    protected function getEstateService(): EstateService
    {
        return app(EstateService::class);
    }

}
