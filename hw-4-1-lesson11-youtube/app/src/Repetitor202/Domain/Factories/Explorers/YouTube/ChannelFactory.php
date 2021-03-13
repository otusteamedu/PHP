<?php


namespace Repetitor202\Domain\Factories\Explorers\YouTube;


class ChannelFactory
{
    public function report(array $channelEntities): array
    {
        $report = [];
        foreach ($channelEntities as $channelEntity) {
            $channel = [
                'id' => $channelEntity->getId(),
                'ratioLikeDislike' => $channelEntity->getRatioLikeDislike(),
                'title' => $channelEntity->getTitle(),
            ];
            $report[] = $channel;
        }

        return $report;
    }
}