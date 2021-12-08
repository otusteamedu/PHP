<?php
/**
 * Description of CacheEstateRepository.php
 * @copyright Copyright (c) valyakin.ru
 * @author    Vladimir Valyakin <vladimir@valyakin.ru>
 */

declare(strict_types=1);

namespace App\Services\Estate\Repositories;

use App\Models\User;
use App\Services\Estate\Cache\EstateCacheKeyGenerator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class CacheEstateRepository implements EstateRepositoryInterface
{

    const CACHE_TTL = 300;

    private EloquentEstateRepository $estateRepository;
    private EstateCacheKeyGenerator $estateCacheKeyGenerator;

    /**
     * @param EloquentEstateRepository $estateRepository
     * @param EstateCacheKeyGenerator $estateCacheKeyGenerator
     */
    public function __construct(EloquentEstateRepository $estateRepository, EstateCacheKeyGenerator $estateCacheKeyGenerator)
    {
        $this->estateRepository = $estateRepository;
        $this->estateCacheKeyGenerator = $estateCacheKeyGenerator;
    }

    public function findRealEstate(User $user): ?Collection
    {
        $key = $this->estateCacheKeyGenerator->generateRealEstateUserKey($user->id);
        return Cache::remember($key, self::CACHE_TTL, function () use ($user) {
            return $this->estateRepository->findRealEstate($user);
        });
    }

    public function findMovableEstate(User $user): ?Collection
    {
        $key = $this->estateCacheKeyGenerator->generateMovableEstateUserKey($user->id);
        return Cache::remember($key, self::CACHE_TTL, function () use ($user) {
            return $this->estateRepository->findMovableEstate($user);
        });
    }
}
