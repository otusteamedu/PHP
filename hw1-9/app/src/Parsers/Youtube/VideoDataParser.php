<?php
namespace Src\Parsers\Youtube;

use Src\DTO\VideoDTO;
use Src\Messages\Responser;

/**
 * Class VideoDataParser
 *
 * @package Src\Parsers\Youtube
 */
class VideoDataParser
{
    /**
     * @param array $videoIdsInfo
     *
     * @return array
     * @throws \Exception
     */
    public function parseVideosIdList(array $videoIdsInfo): array
    {
        $result = [];

        if (empty($videoIdsInfo['items'])) {
            Responser::responseParseDataFail('Video list is not exists');
        }
        foreach ($videoIdsInfo['items'] as $video) {
                $result[] = $video['id']['videoId'];
        }

        return $result;
    }

    /**
     * @param array $videoInfo
     *
     * @return VideoDTO|null
     * @throws \Exception
     */
    public function parseVideoData(array $videoInfo): ?VideoDTO
    {
        return $this->getVideoDTO($videoInfo);
    }

    /**
     * @param $rawData
     *
     * @return \Src\DTO\VideoDTO
     * @throws \Exception
     */
    private function getVideoDTO($rawData): VideoDTO
    {
        $id = $rawData['items'][0]['id'] ?? '';

        if (empty($id)) {
            Responser::responseParseDataFail('Video id is not exists');
        }

        $title = $rawData['items'][0]['snippet']['title'] ?? '';

        if (empty($title)) {
            Responser::responseParseDataFail('Video title is not exists');
        }

        $channelId = $rawData['items'][0]['snippet']['channelId'] ?? '';

        if (empty($channelId)) {
            Responser::responseParseDataFail('Video channelId is not exists');
        }

        $viewsCount = $rawData['items'][0]['statistics']['viewCount'] ?? 0;
        $likesCount = $rawData['items'][0]['statistics']['likeCount'] ?? 0;
        $dislikesCount = $rawData['items'][0]['statistics']['dislikeCount'] ?? 0;
        $commentsCount = $rawData['items'][0]['statistics']['commentCount'] ?? 0;

        return new VideoDTO(
            $id,
            $title,
            $channelId,
            $viewsCount,
            $likesCount,
            $dislikesCount,
            $commentsCount,
        );
    }
}
