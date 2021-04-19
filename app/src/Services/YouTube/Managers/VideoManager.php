<?php


namespace App\Services\YouTube\Managers;

use App\Services\YouTube\DataTransferObjects\VideoDTO;
use App\Services\YouTube\Endpoints\ListVideos;
use App\Services\YouTube\Exceptions\YouTubeApiBadResponseException;

class VideoManager
{
    /**
     * @param array $ids
     * @param int $maxResults
     * @param int $pagesCount
     * @return array | VideoDTO[]
     * @throws YouTubeApiBadResponseException
     */
    public function listVideosByIds(array $ids, int $maxResults = 50, int $pagesCount = 1) : array
    {
        $endpoint = new ListVideos();

        $pageToken = null;
        $result = [];

        while(count($result) < $maxResults * $pagesCount){

            $response = $endpoint->execute('snippet,contentDetails,statistics', [
                'id'=> implode(',', $ids),
                'maxResults' => $maxResults,
                'pageToken' => $pageToken,
            ]);

            foreach($response->getItems() as $item){
                $videoDTO = new VideoDTO($item->getId());
                $videoDTO->setChannelId($item->getSnippet()->getChannelId());
                $videoDTO->setDescription($item->getSnippet()->getDescription());
                $videoDTO->setTitle($item->getSnippet()->getTitle());
                $videoDTO->setLikeCount($item->getStatistics()->getLikeCount() ?? 0);
                $videoDTO->setDislikeCount($item->getStatistics()->getDislikeCount() ?? 0);
                $videoDTO->setCommentCount($item->getStatistics()->getCommentCount() ?? 0);
                $videoDTO->setFavoriteCount($item->getStatistics()->getFavoriteCount() ?? 0);
                $videoDTO->setViewCount($item->getStatistics()->getViewCount() ?? 0);
                $videoDTO->setPublishedAt($item->getSnippet()->getPublishedAt());
                $result[] = $videoDTO;
            }

            $pageToken = $response->getNextPageToken();

            if(!$pageToken){
                break;
            }
        }

        return $result;
    }
}