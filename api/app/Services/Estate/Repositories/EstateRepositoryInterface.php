<?php
/**
 * Description of EstateRepositoryInterface.php
 * @copyright Copyright (c) valyakin.ru
 * @author    Vladimir Valyakin <vladimir@valyakin.ru>
 */

namespace App\Services\Estate\Repositories;


use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface EstateRepositoryInterface
{
    /**
     * @param User $user
     * @return Collection|null
     */
    public function findRealEstate(User $user): ?Collection;

    /**
     * @param User $user
     * @return Collection|null
     */
    public function findMovableEstate(User $user): ?Collection;
}
