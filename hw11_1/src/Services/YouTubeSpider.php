<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\Storage;
use App\Entities\{YouTubeCategory, YouTubeChannel, YouTubeVideo};
use App\Contracts\IO\{Input, Output};
use App\Contracts\YouTubeDriver;

class YouTubeSpider
{
    /**
     * @var Output
     */
    private $output;
    /**
     * @var Input
     */
    private $input;
    /**
     * @var YouTubeDriver
     */
    private $driver;

    /**
     * @param Input $input
     * @param Output $output
     * @param YouTubeDriver $driver
     */
    public function __construct(Input $input, Output $output, YouTubeDriver $driver)
    {
        $this->output = $output;
        $this->input = $input;
        $this->driver = $driver;
    }

    /**
     * @param string $regionCode
     * @param string $breakCommand
     * @return YouTubeCategory|null
     */
    public function selectCategory(string $regionCode, string $breakCommand = 'quit'): ?YouTubeCategory
    {
        $categories = $this->driver->getRegionCategories('RU');

        $countResult = count($categories);

        $this->output->info("Select the category (1-$countResult):");
        foreach ($categories as $key => $category) {
            $optionNum = $key + 1;
            $this->output->writeLn("{$optionNum}. {$category['title']}");
        }

        $continue = true;
        $category = null;

        while ($continue) {
            $line = $this->input->readLn("Select category 1-$countResult, \"$breakCommand\" for cancel: ");

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

            $category = YouTubeCategory::fromArray($categories[$key]);

            $this->output->info("Category \"{$category->getTitle()}\" selected.");
            $continue = false;
        }

        return $category;
    }

    /**
     * @param YouTubeCategory $category
     * @param Storage $storage
     */
    public function saveCategoryChannels(YouTubeCategory $category, Storage $storage): void
    {
        $channels = $this->driver->getCategoryChannels($category);

        foreach ($channels as $channel) {
            /** @var YouTubeChannel $channel */
            /** @var YouTubeVideo[] $videos */
            $channel->addVideos(
                $this->driver->getChannelVideos($channel->getId())
            );

            $videoIds = $channel->getVideos()->pluck('id');

            $statistics = $this->driver->getVideoStatistics($videoIds);

            foreach ($channel->getVideos() as $video) {
                if (array_key_exists($video->getId(), $statistics)) {
                    $video->setCommentCount($statistics[$video->getId()]['commentCount'])
                        ->setViewsCount($statistics[$video->getId()]['viewsCount'])
                        ->setLikeCount($statistics[$video->getId()]['likeCount'])
                        ->setDislikeCount($statistics[$video->getId()]['dislikeCount']);
                }
            }

            $storage->insert($channel->toArray());
        }
    }
}
