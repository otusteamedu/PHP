<?php
/**
 * Description of EstateCacheKeyGenerator.php
 * @copyright Copyright (c) valyakin.ru
 * @author    Vladimir Valyakin <vladimir@valyakin.ru>
 */

namespace App\Services\Estate\Cache;


class EstateCacheKeyGenerator
{

    const REAL_ESTATE_KEY_PREFIX = 'real.estate.by_user.';
    const MOVABLE_ESTATE_KEY_PREFIX = 'movable.estate.by_user.';

    /**
     * @param int $user_id
     * @param int $limit
     * @param int $offset
     * @return string
     */
    public function generateMovableEstateUserKey(int $user_id, int $limit = 10, int $offset = 0): string
    {
        return self::MOVABLE_ESTATE_KEY_PREFIX . implode('.', [
                $user_id,
                $limit,
                $offset,
            ]);
    }

    /**
     * @param int $user_id
     * @param int $limit
     * @param int $offset
     * @return string
     */
    public function generateRealEstateUserKey(int $user_id, int $limit = 10, int $offset = 0): string
    {
        return self::REAL_ESTATE_KEY_PREFIX . implode('.', [
                $user_id,
                $limit,
                $offset,
            ]);
    }

}
