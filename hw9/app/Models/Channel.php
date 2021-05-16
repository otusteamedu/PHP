<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Searchable;

class Channel extends Model
{
    use HasFactory;
    use Searchable;

    protected $guarded = [];
    public $fillable = [
        'channel_id',
        'name',
        'views',
        'likes',
        'dislikes',
    ];

    public function toPublic(): array
    {
        return [
            'channel_id' => $this->channel_id,
            'name' => $this->name,
            'likes' => number_format($this->likes, 0, '.', ' '),
            'dislikes' => number_format($this->dislikes, 0, '.', ' '),
            'views' => number_format($this->views, 0, '.', ' ')
        ];
    }
}
