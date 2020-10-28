<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface SearchableInterface {
    public function search(string $query = ''): Collection;
}
