<?php


namespace App\Models\Traits;


trait Searchable
{
    public function getSearchIndex(): string
    {
        return $this->getTable() . '_index';
    }

    public function getSearchType(): string
    {
        if (property_exists($this, 'useSearchType')) {
            return $this->useSearchType;
        }
        return $this->getTable() . '_index';
    }

    public function toSearchArray(): array
    {
        return $this->toArray();
    }
}
