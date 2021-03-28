<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChannelVideo extends Model
{
    use HasFactory;

    protected $fillable = ['channel_id', 'url', 'likes', 'dislikes', 'views', 'youtube_id'];
    protected $appends = ['url'];

    public function getUrlAttribute(): ?string
    {
        return $this->youtube_id ? "https://www.youtube.com/watch?v={$this->youtube_id}" : null;
    }
}
