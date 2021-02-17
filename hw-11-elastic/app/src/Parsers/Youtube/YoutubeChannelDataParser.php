<?php

namespace Parsers\Youtube;

use Models\ChannelDTO;
use Exception;

class YoutubeChannelDataParser
{
    public function parse (string $json): ChannelDTO
    {
        $rawData = json_decode($json, true);

        return $this->makeDTO($rawData);
    }

    private function makeDTO ($rawData): ChannelDTO
    {
        $id = $rawData['items'][0]['id'] ?? '';

        if (empty($id)) {
            throw new Exception('Channel id is not parsed');
        }

        $title = $rawData['items'][0]['snippet']['title'] ?? '';

        if (empty($title)) {
            throw new Exception('Title is not parsed');
        }

        $description = $rawData['items'][0]['snippet']['description'] ?? '';
        $thumbmail   = $rawData['items'][0]['snippet']['thumbnails']['default']['url'] ?? '';

        return new ChannelDTO(
            $id,
            $title,
            $description,
            $thumbmail
        );
    }
}