<?php

namespace App\Models;

use App\Models\Traits\HasSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\Youtube\ChannelStatisticService;

/**
 * Class Channel
 * @package App\Models
 * @property int id
 * @property string youtube_channel_id
 * @property string title
 * @property string description
 * @property string likes
 * @property string dislikes
 * @property string views
 * @property string comments
 *
 */
class Channel extends Model
{
    use HasFactory;
    use HasSearch;

    public $fillable = [
        'id',
        'youtube_channel_id',
        'title',
        'description',
    ];

    private array $videos;

    /**
     * @param array $videos
     */
    public function setVideos(array $videos): void
    {
        $this->videos = $videos;
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }
}
