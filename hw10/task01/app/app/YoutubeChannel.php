<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class YoutubeChannel extends Model
{
    protected $collection = 'youtube_channels';
    protected $fillable = ['title','code', 'created_at'];
}
