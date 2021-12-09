<?php
/**
 * Description of EstateService.php
 * @copyright Copyright (c) valyakin.ru
 * @author    Vladimir Valyakin <vladimir@valyakin.ru>
 */

declare(strict_types=1);

namespace App\Services\Estate;

use App\Models\User;
use App\Services\Estate\Jobs\FindUserMovableEstateJob;
use App\Services\Estate\Jobs\FindUserRealEstateJob;

class EstateService
{
    /**
     * Отправляет в очередь запрос на поиск всего имущества пользователя
     *
     * @param User $user
     */
    public function findAll(User $user)
    {
        $this->findMovableEstate($user);
        $this->findRealEstate($user);
    }

    /**
     * Ставит в очередь поиск движемого имущества
     *
     * @param User $user
     */
    public function findMovableEstate(User $user)
    {
        FindUserMovableEstateJob::dispatch($user);
    }

    /**
     * Ставит в очередь поиск недвижемого имущества
     *
     * @param User $user
     */
    public function findRealEstate(User $user)
    {
        FindUserRealEstateJob::dispatch($user);
    }

}
