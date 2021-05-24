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
        return property_exists($this, 'searchType') ? $this->searchType : $this->getTable() . '_index';
    }

    public function toSearchArray(): array
    {
        return $this->toArray();
    }
}
