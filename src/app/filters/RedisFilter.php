<?php

namespace Filter;

use Repository\EventsRepository;

class RedisFilter extends CommonFilter
{
    public const CONDITION = "Param";
    public const PRIORITY = "priority";

    /** @var array $conditions */
    protected array $conditions = [];

    public function buildFromArray(array $rowFilter)
    {
        parent::buildFromArray($rowFilter);

        $this->conditions = self::parseConditions($rowFilter);
    }

    /**
     * @param $filter
     * @return array
     */
    public static function parseConditions(array $filter): array
    {
        return array_filter($filter, function ($key) {
            return strpos($key, self::CONDITION) === 0;
        }, ARRAY_FILTER_USE_KEY);
    }

    /**
     * @return string
     */
    public function getHashKey(): string
    {
        return EventsRepository::getEntityConditionKey($this->fetch());
    }

    /**
     * @return array
     */
    public function fetch(): array
    {
        return $this->conditions;
    }
}