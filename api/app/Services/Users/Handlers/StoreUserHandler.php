<?php

namespace App\Services\Users\Handlers;


use App\Services\Users\DTO\StoreUserDTO;
use App\Services\Users\Repositories\UserRepositoryInterface as UserRepository;

class StoreUserHandler
{

    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(
        UserRepository $userRepository
    )
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param StoreUserDTO $dto
     */
    public function handle(StoreUserDTO $dto): void
    {
        $this->userRepository->store($dto);
    }

}
