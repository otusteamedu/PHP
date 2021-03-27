<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use HasFactory, Searchable;

    protected $casts = [
        'tags'           => 'json',
        'total_likes'    => 'integer',
        'total_dislikes' => 'integer',
        'total_views'    => 'integer',
    ];

    protected $appends = [
        'total_likes',
        'total_dislikes',
        'total_views',
        'ratio',
        'url'
    ];
    protected $fillable = [
        'id',
        'name',
        'youtube_id',
        'url',
        'description',
        'tags',
        'total_likes'
    ];


    public function videos()
    {
        return $this->hasMany(ChannelVideo::class, 'channel_id', 'id');
    }

    public function setTotalLikesAttribute(int $value)
    {
        $this->attributes['total_likes'] = $value;
    }

    public function getTotalLikesAttribute(): int
    {
        return $this->videos->sum('likes');
    }

    public function getTotalDislikesAttribute(): int
    {
        return $this->videos->sum('dislikes');
    }

    public function getRatioAttribute(): float
    {
        return round($this->totalLikes / ($this->totalDislikes > 0 ? $this->totalDislikes : 1), 2);
    }

    public function getTotalViewsAttribute(): int
    {
        return $this->videos->sum('views');
    }

    public function getUrlAttribute(): ?string
    {
        return $this->youtube_id ? "https://www.youtube.com/channel/{$this->youtube_id}" : null;
    }

    public function toSearchArray()
    {
        return collect($this->toArray())->except(['videos'])->toArray();
    }
}
