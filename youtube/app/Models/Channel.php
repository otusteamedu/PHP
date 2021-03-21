<?php

namespace App\Models;

use App\Models\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Channel
 * @package App\Models
 * @property string $channel_id
 * @property string $name
 * @property int $views
 * @property int $likes
 * @property int $dislikes
 */
class Channel extends Model
{
    use HasFactory;
    use Searchable;

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
            'name' => $this->name,
            'likes' => number_format($this->likes, 0, '.', ' '),
            'dislikes' => number_format($this->dislikes, 0, '.', ' '),
            'views' => number_format($this->views, 0, '.', ' ')
        ];
    }
}
