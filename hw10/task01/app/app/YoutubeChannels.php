<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class YoutubeChannels extends Model
{
    protected $collection = 'youtube_channels';
    protected $fillable = ['title','code'];
}
