<?php

namespace App\Command;

use App\Core\AbstractController;
use Elasticsearch\ClientBuilder;

class TestController extends AbstractController
{
    public function indexAction()
    {
        $client = ClientBuilder::create()->setHosts([
            'es01'
        ])->build();
//        $client->putScript();
//        $response = $client->index([
//            'index' => 'my_index',
//            'id'    => 'my_id2',
//            'body'  => ['testField' => 'testing 312 aaa']
//        ]);
        $response = $client->get([
            'index' => 'channel',
            'id'    => 'UCcflkwK_x06dRihzLiPXCrA',
        ]);
//        $response = $client->search([
//            'index' => 'channel',
//            'body'  => [
//                'query' => [
//                    'match_all' => [],
//                ],
//                'fields' => ['_id']
//            ]
//        ]);
        print_r($response);
    }

    public function youtubeAction()
    {
        $client = new \Google_Client();
        $client->setApplicationName('otus-homework-304004');
        $client->setDeveloperKey('AIzaSyDskgAdxxmn5H6DL8qpsvsHlGSX-bDXFDc');

        $service = new \Google_Service_YouTube($client);
        $response = $service->channels->listChannels(['contentDetails'], [
            'id' => 'UCcflkwK_x06dRihzLiPXCrA',
        ]);
        foreach ($response->getItems() as $channel) {
            $uploads = $channel->getContentDetails()->getRelatedPlaylists()->getUploads();
            $this->app()->logger()->writeln(print_r($uploads, true));

            $videoIds = [];
            $pageToken = null;
            while ($pageToken !== false) {
                $list = $service->playlistItems->listPlaylistItems(['contentDetails'], [
                    'playlistId' => $uploads,
                    'maxResults' => 50,
                    'pageToken' => $pageToken,
                ]);
                foreach ($list->getItems() as $video) {
                    $videoIds[] = $video->getContentDetails()->getVideoId();
                }
                $pageToken = $list->getNextPageToken() ?: false;
            }
            if ($videoIds) {
                $videosStats = $service->videos->listVideos(['snippet', 'statistics'], [
                    'id' => implode(',', $videoIds)
                ]);
                foreach ($videosStats->getItems() as $videoStat) {
                    $data = [
                        'title' => $videoStat->getSnippet()->getTitle(),
                        'likes' => $videoStat->getStatistics()->getLikeCount(),
                        'dis' => $videoStat->getStatistics()->getDislikeCount(),
                    ];
                }
            }
        }
    }
}
