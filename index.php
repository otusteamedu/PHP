<?php

if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
    throw new Exception(sprintf('Please run "composer require google/apiclient:~2.0" in "%s"', __DIR__));
}
require_once __DIR__ . '/vendor/autoload.php';

use Youtubestat\Ustat;

try {

    $params = [
        'client_id' => '899632747294-df8fm6buohraml1gq9lj67anio1lsgqi.apps.googleusercontent.com',
        'client_secret' => 'oMOhUtKGwhQIfkVyHIeOScyC',
        'refresh_token' => '1/0ETQq8vdh4ilfOks8Z6GDBOf1Bdrc9vjFjOJUm2ddF3SOEoY4GPYr2jydUg99Acu',
        'credentials_json_file' => '',
        'scope' => 'https://www.googleapis.com/auth/youtube.readonly',
        'db_structure' => ['youtube', 'channels']
    ];

    $app = new Ustat($params);


    //check that we have something in db
    $data = $app->getAllData();
    //if db not empty get statistic
    if (!empty($data)) {
        //get top of likes and dislikes
        list($topLikes, $topDislikes) = $app->getTopChannels();

        foreach ($topDislikes as $document) {
            printf("%s have likes: %s and dislikes: %s<br>", $document['_id']['channelTitle'], $document['likes'], $document['disLikes']);
        }

        echo '<br><br>Data for channel with name "YoungBoy Never Broke Again"<br>';//'UC7vVhkEfw4nOGp8TyDk7RcQ'
        $data = $app->getChannelStatByName('YoungBoy Never Broke Again'); //'UC7vVhkEfw4nOGp8TyDk7RcQ'

        foreach ($data as $document) {
            printf("likes: %d<br>dislikes: %d<br>comments: %d<br>view: %d", $document['likes'], $document['disLikes'],  $document['comments'],  $document['view']);
        }
        exit;
    }


    //if we haven't data in the database we make request to youtube top video chart
    $topVideos = $app->getTopVideos();

    $channelIds = [];

    $data = [];


    if (count($topVideos)) {
        //walk through all returned videos and get all videos from this channel
        foreach ($topVideos as $video) {
            if (
                !empty($video->snippet->channelId)
                &&
                !in_array($video->snippet->channelId, $channelIds)
            ) {
                //save channelID and not get info for this channel in next time
                $channelIds[] = $video->snippet->channelId;

                //get all videos for this channel
                $channelVideos = $app->getAllVideos4Channel($video->snippet->channelId);

                $videoIds = [];

                $channelVideoData = [];

                //gather video for this channel
                if (!empty($channelVideos)) {
                    foreach ($channelVideos as $channelVideo) {
                        if (
                            !empty($channelVideo->id->kind)
                            &&
                            $channelVideo->id->kind === 'youtube#video'
                            &&
                            !empty($channelVideo->id->videoId)
                        ) {

                            $videoIds[] = $channelVideo->id->videoId;
                            $channelVideoData[] = [
                                'title' => isset($channelVideo->snippet->title)
                                    ? $channelVideo->snippet->title
                                    : '',
                                'publishedAt' => isset($channelVideo->snippet->publishedAt)
                                    ? $channelVideo->snippet->publishedAt
                                    : '',
                                'description' => isset($channelVideo->snippet->description)
                                    ? $channelVideo->snippet->description
                                    : '',
                                'thumbnail' => isset($channelVideo->snippet->thumbnails->high->url)
                                    ? $channelVideo->snippet->thumbnails->high->url
                                    : '',
                                'statistics' => [
                                    'commentCount' => 0,
                                    'dislikeCount' => 0,
                                    'favoriteCount' => 0,
                                    'likeCount' => 0,
                                    'viewCount' => 0
                                ]
                            ];
                        }
                    }

                    //get statistics for videos
                    if (!empty($videoIds)) {
                        $videosStat = $app->getVideoStatistics($videoIds);
                        if (!empty($videosStat)) {
                            foreach ($videosStat as $stat) {
                                $key = array_search($stat->id, $videoIds);
                                if (!empty($key)) {
                                    $channelVideoData[$key]['statistics'] = [
                                        'commentCount' => isset($stat->statistics->commentCount)
                                            ? (int)$stat->statistics->commentCount
                                            : 0,
                                        'dislikeCount' => isset($stat->statistics->dislikeCount)
                                            ? (int)$stat->statistics->dislikeCount
                                            : 0,
                                        'favoriteCount' => isset($stat->statistics->favoriteCount)
                                            ? (int)$stat->statistics->favoriteCount
                                            : 0,
                                        'likeCount' => isset($stat->statistics->likeCount)
                                            ? (int)$stat->statistics->likeCount
                                            : 0,
                                        'viewCount' => isset($stat->statistics->viewCount)
                                            ? (int)$stat->statistics->viewCount
                                            : 0,
                                    ];
                                }
                            }
                        }
                    }
                }
                //end video for channel


                if (!empty($channelVideoData)) {
                    $data = [
                        'channelId' => $video->snippet->channelId,
                        'channelTitle' => $video->snippet->channelTitle,
                        'channelVideos' => $channelVideoData
                    ];

                    $result = $app->saveChannelData($data);

                    if (!empty($result)) {
                        echo $video->snippet->channelId . ' ' . $video->snippet->channelTitle . ' ' . count($channelVideoData) . '<br>';
                    }
                }

            }
        }
    }

} catch (Exception $e) {
    echo 'Error happen due request. Error message: ' . $e->getMessage() . ' file: ' . $e->getFile() . ' Line: ' . $e->getLine();
}
