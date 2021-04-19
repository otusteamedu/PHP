<?php

namespace App\Services\YouTube\Managers;

use App\Services\YouTube\DataTransferObjects\ChannelDTO;
use App\Services\YouTube\Endpoints\ListChannels;
use App\Services\YouTube\Endpoints\ListSearch;
use App\Services\YouTube\Exceptions\YouTubeApiBadResponseException;

class ChannelManager
{
    /**
     * @param string $queryString
     * @param int $maxResults
     * @param int $pagesCount
     * @return array | string[] Channels Ids
     * @throws YouTubeApiBadResponseException
     */
    public function searchByString(string $queryString, int $maxResults = 50, int $pagesCount = 1) : array
    {
        $endpoint = new ListSearch();
        $pageToken = null;
        $result = [];

        while(count($result) < $maxResults * $pagesCount){

            $response = $endpoint->execute('snippet', array_filter([
                'q'=> $queryString,
                'maxResults' => $maxResults,
                'type' => 'channel',
                'pageToken' => $pageToken,
            ]));

            foreach($response->getItems() as $item){
                $result[] = $item->getId()->getChannelId();
            }

            $pageToken = $response->getNextPageToken();

            if(!$pageToken){
                break;
            }
        }

        return $result;
    }

    /**
     * @param array $ids
     * @param int $maxResults
     * @param int $pagesCount
     * @return array | ChannelDTO[]
     * @throws YouTubeApiBadResponseException
     */
    public function listChannelsByIds(array $ids, int $maxResults = 50, int $pagesCount = 1) : array
    {
        $endpoint = new ListChannels();

        $pageToken = null;
        $result = [];

        while(count($result) < $maxResults * $pagesCount){

            $response = $endpoint->execute('snippet,contentDetails,statistics', [
                'id'=> implode(',', $ids),
                'maxResults' => $maxResults,
                'pageToken' => $pageToken,
            ]);

            foreach($response->getItems() as $item){
                $channelDTO = new ChannelDTO($item->getId());
                $channelDTO->setDescription($item->getSnippet()->getDescription());
                $channelDTO->setTitle($item->getSnippet()->getTitle());
                $channelDTO->setSubscribersCount($item->getStatistics()->getSubscriberCount() ?? 0);
                $channelDTO->setVideosCount($item->getStatistics()->getVideoCount());
                $channelDTO->setViewsCount($item->getStatistics()->getViewCount());
                $channelDTO->setPlaysListItemsUploadsId($item->getContentDetails()->getRelatedPlaylists()->getUploads());
                $result[] = $channelDTO;
            }

            $pageToken = $response->getNextPageToken();

            if(!$pageToken){
                break;
            }
        }

        return $result;
    }
}