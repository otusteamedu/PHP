<?php
/**
 * Description of EloquentUserRepository.php
 * @copyright Copyright (c) valyakin.ru, LLC
 * @author    Vladimir Valyakin <vladimir@valyakin.ru>
 */

namespace App\Services\Users\Repositories;


use App\Models\User;
use App\Services\Users\DTO\StoreUserDTO;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{

    public function find(int $id): ?User;
    public function store(StoreUserDTO $dto): User;
    public function getActiveUsers(int $id, int $limit, int $offset = 0): Collection;

}
