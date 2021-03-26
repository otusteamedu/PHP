<?php

namespace App\Parsers;

use App\Exceptions\DataParserException;
use App\Log\Log;
use App\Models\DTO\ChannelDTO;
use Monolog\Logger;

class YoutubeChannelDataParser
{
    public function parse (string $json): ?ChannelDTO
    {
        $rawData = json_decode($json, true);

        try {
            $dto = $this->makeDTO($rawData);
        } catch (DataParserException $e) {
            Log::getInstance()->addRecord('Error in parsing data: ' . $e->getMessage(), Logger::ERROR);
            return null;
        }

        return $dto;
    }

    private function makeDTO ($rawData): ChannelDTO
    {
        $id = $rawData['items'][0]['id'] ?? '';

        if (empty($id)) {
            throw new DataParserException('Channel id is not parsed');
        }

        $title = $rawData['items'][0]['snippet']['title'] ?? '';

        if (empty($title)) {
            throw new DataParserException('Title is not parsed');
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