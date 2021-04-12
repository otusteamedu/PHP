<?php

declare(strict_types=1);

namespace App\Command;

use App\Console\Console;
use App\Service\YouTube\Crawler\YouTubeCrawler;

class RunCrawlerCommand implements CommandInterface
{

    private YouTubeCrawler $youTubeCrawler;

    public function __construct(YouTubeCrawler $youTubeCrawler)
    {
        $this->youTubeCrawler = $youTubeCrawler;
    }

    public function execute(): void
    {
        if (!$channelIdsByChunks = array_chunk($this->getChannelIds(), 5)) {
            Console::info('Не указан список каналов для обработки');

            return;
        }

        $count = 0;
        foreach ($channelIdsByChunks as $channelIds) {

            $this->youTubeCrawler->craw($channelIds);

            $count += count($channelIds);

            Console::info("Обработано каналов $count");
        }

        Console::success('Обработка завершена');
    }

    private function getChannelIds(): array
    {
        return Console::readLines();
    }

}