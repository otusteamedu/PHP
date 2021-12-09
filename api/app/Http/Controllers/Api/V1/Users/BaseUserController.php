<?php

namespace App\Http\Controllers\Api\V1\Users;


use App\Http\Controllers\Controller;
use App\Services\Estate\EstateService;
use App\Services\Users\UserService;

class BaseUserController extends Controller
{
    const USERS_PER_PAGE = 25;
    const MAX_USERS_PER_PAGE = 100;
    const ESTATE_USER_ANSWER = 'The estate search request has been accepted. Expect an answer';

    protected function getUserService(): UserService
    {
        return app(UserService::class);
    }

    protected function getEstateService(): EstateService
    {
        return app(EstateService::class);
    }

}
