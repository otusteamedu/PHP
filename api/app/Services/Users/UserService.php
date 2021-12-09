<?php

namespace App\Services\Users;

use App\Services\Users\DTO\StoreUserDTO;
use App\Services\Users\Jobs\StoreUserJob;


class UserService
{
    public function storeUser(StoreUserDTO $dto)
    {
        StoreUserJob::dispatch($dto);
    }

}
