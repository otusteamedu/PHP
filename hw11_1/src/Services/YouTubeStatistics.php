<?php

declare(strict_types=1);

namespace App\Services;

use App\Entities\YouTubeCategory;
use App\Entities\YouTubeChannel;
use App\Contracts\IO\{Input, Output};
use App\Contracts\Storage;

class YouTubeStatistics
{
    /**
     * @var Storage
     */
    protected $storage;
    /**
     * @var Output
     */
    private $output;
    /**
     * @var Input
     */
    private $input;

    public function __construct(Storage $storage, Output $output, Input $input)
    {
        $this->storage = $storage;
        $this->output = $output;
        $this->input = $input;
    }

    /**
     * @param string $breakCommand
     * @return YouTubeChannel|null
     */
    public function selectChannel(string $breakCommand = 'quit'): ?YouTubeChannel
    {
        $channels = $this->storage->getAll();

        $countResult = count($channels);

        if ($countResult === 0) {
            $this->output->writeLn('No channels.');
            return null;
        }

        $this->output->info("Select the channel (1-$countResult):");
        foreach ($channels as $key => $channel) {
            $optionNum = $key + 1;
            $obj = YouTubeChannel::createFromObject($channel);
            $this->output->writeLn("{$optionNum}. {$obj->getTitle()}");
        }

        $continue = true;
        $channel = null;

        while ($continue) {
            $line = $this->input->readLn("Select channel 1-$countResult, \"$breakCommand\" for cancel: ");

            if ($line === $breakCommand) {
                $continue = false;
                continue;
            }

            if (!is_numeric($line)) {
                $this->output->error("Number 1-$countResult required.");
                continue;
            }

            $key = (int)$line - 1;
            if ($key < 1 || $key > $countResult) {
                $this->output->error("Number 1-$countResult required.");
                continue;
            }

            $channel = YouTubeChannel::createFromObject($channels[$key]);

            $this->output->info("Channel \"{$channel->getTitle()}\" selected.");
            $continue = false;
        }

        return $channel;
    }

    /**
     * @param string $channelId
     * @return array
     */
    public function getStatisticsOfChannelVideos(string $channelId): array
    {
        $channel = $this->storage->getById($channelId);
        $channel = YouTubeChannel::createFromObject($channel);

        return [
            'channel' => [
                'id' => $channel->getId(),
                'title' => $channel->getTitle(),
            ],
            'statistics' => [
                'likes' => $channel->totalLikesCount(),
                'dislikes' => $channel->totalDislikesCount(),
            ],
        ];
    }

    /**
     * @param int $channelsCount
     * @return array
     */
    public function getTopChannels(int $channelsCount = 3): array
    {
        $channels = $this->storage->getAll();

        if (count($channels) < $channelsCount) {
            $channelsCount = count($channels);
        }

        $data = [];

        foreach ($channels as $channel) {
            $channel = YouTubeChannel::createFromObject($channel);
            $data[] = [
                'channel' => [
                    'id' => $channel->getId(),
                    'title' => $channel->getTitle(),
                ],
                'statistics' => [
                    'likes' => $channel->totalDislikesCount(),
                    'dislikes' => $channel->totalDislikesCount(),
                    'ratio' => $channel->likesDislikesRatio(),
                ],
            ];
        }

        usort($data, function ($item1, $item2) {
            $result = $item1['statistics']['ratio'] <=> $item2['statistics']['ratio'];
            return 0 - $result;
        });

        return array_slice($data, 0, $channelsCount);
    }
}
