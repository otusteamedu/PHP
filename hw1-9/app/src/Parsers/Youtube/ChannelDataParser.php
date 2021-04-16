<?php
namespace Src\Parsers\Youtube;

use Src\DTO\ChannelDTO;
use Src\Messages\Responser;

/**
 * Class ChannelParser
 *
 * @package App\Parsers\Youtube
 */
class ChannelDataParser
{
    /**
     * @param $channelInfo
     *
     * @return \Src\DTO\ChannelDTO
     * @throws \Exception
     */
    public function parse($channelInfo): ChannelDTO
    {
        return $this->getChannelDTO($channelInfo);
    }

    /**
     * @param $rawData
     *
     * @return \Src\DTO\ChannelDTO
     * @throws \Exception
     */
    private function getChannelDTO($rawData): ChannelDTO
    {
        $id = $rawData['items'][0]['id'] ?? '';

        if (empty($id)) {
            Responser::responseParseDataFail('Channel id is not exists');
        }

        $title = $rawData['items'][0]['snippet']['title'] ?? '';

        if (empty($title)) {
            Responser::responseParseDataFail('Channel title is not exists');
        }

        $description = $rawData['items'][0]['snippet']['description'] ?? '';

        if (empty($description)) {
            Responser::responseParseDataFail('Channel description is not exists');
        }

        $thumbnail = $rawData['items'][0]['snippet']['thumbnails']['default']['url'] ?? '';

        if (empty($thumbnail)) {
            Responser::responseParseDataFail('Channel thumbnail is not exists');
        }

        return new ChannelDTO(
            $id,
            $title,
            $description,
            $thumbnail
        );
    }
}