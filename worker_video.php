<?php
use Alex\Youtubestat\Config;
use Alex\Youtubestat\Ustat;

require_once 'vendor/autoload.php';

$config = new Config();

$params = [
    'client_id' => $config->api_client_id,
    'client_secret' => $config->api_client_secret,
    'refresh_token' => $config->api_refresh_token,
    'credentials_json_file' => $config->api_credentials_json_file,
    'scope' => $config->api_scope,
    'db_structure' => $config->api_db_structure
];

$app = new Ustat($params);

$redis = new \Redis();
$redis->pconnect($config->redis_host, $config->redis_port);

while($data = $redis->lPop($config->request_list_video_name)) {
    $raw_data = json_decode($data);
    if (!empty($raw_data)) {
        $videoId = $raw_data->id;
        $resultId = $raw_data->resultId;
        $videoData = $app->getVideoStatistics([$videoId]);

        foreach ($videoData as $data) {
            if (isset($data->statistics)) {

                $stat = (array)$data->statistics;

                $insert = [
                    'videoId' => $videoId,
                    'time' => time(),
                    'statistics' => [
                        'commentCount' => $stat['commentCount'],
                        'dislikeCount' => $stat['dislikeCount'],
                        'favoriteCount' => $stat['favoriteCount'],
                        'likeCount' => $stat['likeCount'],
                        'viewCount' => $stat['viewCount'],
                    ]
                ];
                // save to mongo and maybe we can then get data in progress (how much views grow and etc)
                $app->saveChannelData($insert);

                $json_data = json_encode($data->statistics);

                //save to redis for next return to user by result id
                $redis->set($resultId, $json_data);

                break;

            }
        }
    }
}

$redis->close();
