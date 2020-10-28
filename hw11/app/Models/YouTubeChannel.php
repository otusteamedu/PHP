<?php

namespace App\Models;

use App\Observers\ElasticSearchObserver;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;

class YouTubeChannel extends Model {
    use Searchable;

}
