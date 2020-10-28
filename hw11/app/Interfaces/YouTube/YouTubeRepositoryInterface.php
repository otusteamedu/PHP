<?php

namespace App\Interfaces\YouTube;

use Illuminate\Support\Collection;

interface YouTubeRepositoryInterface extends \App\Interfaces\SearchableInterface {
    public function getAll() : Collection;
}
