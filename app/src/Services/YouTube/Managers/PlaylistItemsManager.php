<?php


namespace App\Services\YouTube\Managers;

use App\Services\YouTube\DataTransferObjects\PlaylistItemDTO;
use App\Services\YouTube\Endpoints\ListPlaylistItems;
use App\Services\YouTube\Exceptions\YouTubeApiBadResponseException;

class PlaylistItemsManager
{
    /**
     * @param string $playlistId
     * @param int $maxResults
     * @param int $pagesCount
     * @return array | PlaylistItemDTO[]
     * @throws YouTubeApiBadResponseException
     */
    public function listByPlaylistId(string $playlistId, int $maxResults = 50, int $pagesCount = 1) : array
    {
        $endpoint = new ListPlaylistItems();
        $pageToken = null;
        $result = [];

        while(count($result) < $maxResults * $pagesCount){

            $response = $endpoint->execute('snippet', array_filter([
                'playlistId'=> $playlistId,
                'maxResults' => $maxResults,
                'pageToken' => $pageToken,
            ]));

            foreach($response->getItems() as $item){
                $playlistItemDTO = new PlaylistItemDTO($item->getId());
                $playlistItemDTO->setDescription($item->getSnippet()->getDescription());
                $playlistItemDTO->setTitle($item->getSnippet()->getTitle());
                $playlistItemDTO->setChannelId($item->getSnippet()->getChannelId());
                $playlistItemDTO->setPlaylistId($item->getSnippet()->getPlaylistId());
                $playlistItemDTO->setVideoId($item->getSnippet()->getResourceId()->getVideoId());
                $result[] = $playlistItemDTO;
            }

            $pageToken = $response->getNextPageToken();

            if(!$pageToken){
                break;
            }
        }

        return $result;
    }
}