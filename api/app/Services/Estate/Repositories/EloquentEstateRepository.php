<?php
/**
 * Description of EloquentUserRepository.php
 * @copyright Copyright (c) valyakin.ru
 * @author    Vladimir Valyakin <vladimir@valyakin.ru>
 */

namespace App\Services\Estate\Repositories;


use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class EloquentEstateRepository implements EstateRepositoryInterface
{

    public function findRealEstate(User $user): ?Collection
    {
        sleep(7);
        return Collection::make(['Загородный дом', 'Квартира в Москве', 'Квартира в Париже']);
    }

    public function findMovableEstate(User $user): ?Collection
    {
        sleep(8);
        return Collection::make(['Мерседес S500', 'Снегоход', 'Велосипед']);
    }

}
