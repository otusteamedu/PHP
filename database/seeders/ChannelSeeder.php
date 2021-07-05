<?php

namespace Database\Seeders;

use App\Http\Middleware\YoutubeApiData;
use App\Models\Channel;
use Illuminate\Database\QueryException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;


class ChannelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $youtube = new YoutubeApiData();
        $youtubeChannels = $youtube->getRandomChannels();
        file_put_contents('/var/www/newChannels.txt', print_r($youtubeChannels,true));
        foreach ($youtubeChannels as $channel) {
            $addingChannel = [
                "youtube_channel_id" => $channel['id']['channelId'],
                "title" => $channel['snippet']['title'],
                "description" => $channel['snippet']['description'],
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ];
            try {
                DB::table('channels')->insert($addingChannel);
                echo ".";
            } catch (QueryException $ex) {
                echo "ERROR: Failed to insert ".$channel['id']['channelId']." into Database. ".$ex->getMessage().PHP_EOL.PHP_EOL;
            }
        }
        $video = new VideoSeeder();
        $video->run();
    }
}
