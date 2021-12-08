<?php
/**
 * Description of EloquentUserRepository.php
 * @copyright Copyright (c) valyakin.ru
 * @author    Vladimir Valyakin <vladimir@valyakin.ru>
 */

namespace App\Services\Users\Repositories;


use App\Models\User;
use App\Services\Users\DTO\StoreUserDTO;
use Illuminate\Database\Eloquent\Collection;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function find(int $id): ?User
    {
        return User::find($id);
    }

    public function store(StoreUserDTO $dto): User
    {
        sleep(5);
        return User::create($dto->toArray());
    }

    public function getActiveUsers(int $id, int $limit, int $offset = 0): Collection
    {
        $qb = User::query()
            ->where('id', $id)
            ->where('status', User::STATUS_ACTIVE);
        $qb->take($limit);
        $qb->skip($offset);
        return $qb->get();
    }

}
