<?php

namespace App\Models\Traits;

trait HasElastic
{
    /**
     * Возвращает название индекса
     * @return string
     */
    public function getElasticIndexName(): string
    {
        return $this->getTable() . '_index';
    }

    /**
     * Возвращает тип индекса
     * @return string
     */
    public function getElasticIndexType(): string
    {
        if (property_exists($this, 'useElasticType')) {
            return $this->useElasticType;
        }
        return $this->getTable() . '_index';
    }

    /**
     * Возвращает данные объекта в виде массива
     * @return array
     */
    public function toSearchArray(): array
    {
        return $this->toArray();
    }

}
