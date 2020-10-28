<?php

namespace App\Traits;

use \App\Observers\ElasticSearchObserver;

trait Searchable {
    public static function bootSearchable() {
        static::observe(ElasticSearchObserver::class);
    }

    public function getSearchIndex() {
        return $this->getTable();
    }

    public function getSearchType() {
        if (property_exists($this, 'useSearchType')) {
            return $this->useSearchType;
        }

        return $this->getTable();
    }

    public function toSearchArray() {
        return $this->toArray();
    }
}
