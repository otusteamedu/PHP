<?php


namespace Repetitor202\Domain\Factories\Explorers\YouTube\Video;


abstract class VideoFactory
{
    abstract public function getVideos(array $params = []): ?array;
    abstract public function deleteVideos(array $params): bool;
}