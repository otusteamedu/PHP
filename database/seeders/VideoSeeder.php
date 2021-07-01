<?php

namespace Database\Seeders;

use App\Http\Middleware\YoutubeApiData;
use Illuminate\Database\QueryException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;


class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $youtube = new YoutubeApiData();
        $channels = DB::table('channels')->get();
        foreach ($channels as $channel) {
            if ($channel->id != 81) continue;
            $youtubeVideos = $youtube->getAllVideoFromChannel($channel->youtube_channel_id);
            foreach ($youtubeVideos as $video) {
                if (isset($video['id']['videoId'])) {
                    $videoStatistic = isset($video['id']['videoId']) ? $youtube->getVideoStatisticByVideoId($video['id']['videoId']) : [];
                    $addingVideo = [
                        'channel_id' => $channel->id,
                        'youtube_video_id' => $videoStatistic['id'] ?? null,
                        'title' => $video['snippet']['title'] ?? null,
                        'description' => $video['snippet']['description'] ?? null,
                        'published_at' => isset($video['snippet']['publishedAt']) ? Carbon::createFromDate($video['snippet']['publishedAt']) : null,
                        'view_count' => $videoStatistic['statistics']['viewCount'] ?? 0,
                        'like_count' => $videoStatistic['statistics']['likeCount'] ?? 0,
                        'dislike_count' => $videoStatistic['statistics']['dislikeCount'] ?? 0,
                        'favorite_count' => $videoStatistic['statistics']['favoriteCount'] ?? 0,
                        'comment_count' => $videoStatistic['statistics']['commentCount']?? 0,
                        'tags' => isset($videoStatistic['snippet']['tags']) ? json_encode($videoStatistic['snippet']['tags']) : "[]",
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                    try {
                        DB::table('videos')->insert($addingVideo);
                        echo ".";
                    } catch (QueryException $ex) {
                        echo "EXCEPTION ->" . $ex->getMessage().PHP_EOL;
                    }
                }
            }


        }
    }
}
