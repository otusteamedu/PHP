<?php

namespace API;

use \Google_Client;
use \Google_Service_YouTube;
use \Google_Exception;
use \Google_Service_Exception;
use \Config\ConfigGetter;


class YoutubeVideo
{
    private static $apiKey;
    private static $youtube;
    private static $client;

    public function __construct(Google_Client $client)
    {
        self::$apiKey = ConfigGetter::config('youtube')->apiKey;
        self::$client = $client;
        self::$client->setDeveloperKey(self::$apiKey);
        self::$youtube = new Google_Service_YouTube(self::$client);
    }

    /*
     * Функция получения данных видео по id
     * @param string $id идентификатор видео на youtube
     * @return array
    */
    public function getVideosById(string $id): array
    {

        try {
            // Call the API's videos.list method to retrieve the video resource.
            $response = self::$youtube->videos->listVideos('snippet, statistics, contentDetails', ['id' => $id]);

            return $response->getItems();

        } catch (Google_Service_Exception $e) {

            return sprintf('<p>A service error occurred: <code>%s</code></p>',
                htmlspecialchars($e->getMessage()));

        } catch (Google_Exception $e) {

            return sprintf('<p>An client error occurred: <code>%s</code></p>',
                htmlspecialchars($e->getMessage()));

        }

    }

    /*
     * Функция получения списка ID видео канала
     * @param string $id  идентификатор канала YoutubeController
     * @return array
     */
    public function getСhannelVideosIDs(string $id)
    {
        try {

            $queryParams = [
                'channelId' => $id,
                'order' => 'date',
                'maxResults' => 50,
                'type' => 'video'
            ];

            $response = self::$youtube->search->listSearch('id', $queryParams);
            $response = $response->getItems();

            $videoArray = [];

            foreach($response as $item) {
                array_push($videoArray, $item['id']->videoId);
            }

            return $videoArray;

        } catch (Google_Service_Exception $e) {

            return sprintf('<p>A service error occurred: <code>%s</code></p>',
                htmlspecialchars($e->getMessage()));

        } catch (Google_Exception $e) {

            return sprintf('<p>An client error occurred: <code>%s</code></p>',
                htmlspecialchars($e->getMessage()));

        }
    }

    /*
     * Функция получения информации всех видео канала
     * @param string $id  идентификатор канала YoutubeController
     * @return array
     */

    public function getInfoChannelVideoInfo(string $id)
    {
        $videoString = self::getСhannelVideosIDs($id);
        $videoString = implode(',', $videoString);
        $infoObject = self::getVideosById($videoString);

        $resultArray = ['_id' => $id];

        foreach ($infoObject as $item) {

            $resultArray['videos'][] = [
                'id' => $item['id'],
                'publishedAt' => $item['snippet']['publishedAt'],
                'title' => $item['snippet']['title'],
                'duration' => $item['contentDetails']['duration'],
                'commentCount' => $item['statistics']['commentCount'],
                'dislikeCount' => $item['statistics']['dislikeCount'],
                'likeCount' => $item['statistics']['likeCount'],
                'viewCount' => $item['statistics']['viewCount']
            ];

        }


        return $resultArray;
    }

}
