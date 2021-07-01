<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Video
 * @package App\Models
 * @property int id
 * @property int channel_id
 * @property string youtube_video_id
 * @property string title
 * @property string description
 * @property int view_count
 * @property int like_count
 * @property int dislike_count
 * @property int favorite_count
 * @property int comment_count
 * @property array tags
 */
class Video extends Model
{
    use HasFactory;

    protected $casts = [
      'tags' => 'array',
    ];

    public $fillable = [
        'id',
        'channel_id',
        'youtube_video_id',
        'title',
        'description',
        'view_count',
        'like_count',
        'dislike_count',
        'favorite_count',
        'comment_count',
        'tags',
    ];

    public function getYoutubeId($videoId): string
    {
        return $this->getAttribute('youtube_video_id');
    }
}
