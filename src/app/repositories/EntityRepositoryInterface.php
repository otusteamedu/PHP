<?php

namespace Repository;

use Core\AppConfig;
use Filter\CommonFilter;

interface EntityRepositoryInterface
{
    /**
     * @param AppConfig $appConfig
     */
    public static function initStore(AppConfig $appConfig);

    /**
     * @param CommonFilter $filter
     * @return static[]
     */
    public static function get($filter): array;

    /**
     * @param CommonFilter $filter
     * @return array[]
     */
    public static function fetchList($filter): array;

    /**
     * @param CommonFilter $filter
     * @return int
     */
    public static function deleteCollection($filter): int;

    /**
     * @return bool
     */
    public function create(): bool;

    /**
     * @return bool
     */
    public function update(): bool;

    /**
     * @return bool
     */
    public function delete(): bool;
}