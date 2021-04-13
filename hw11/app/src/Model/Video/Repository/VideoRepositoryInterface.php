<?php

declare(strict_types=1);

namespace App\Model\Video\Repository;

use App\Model\Video\Entity\Video;

interface VideoRepositoryInterface
{

    /**
     * @param string $channelId
     * @param int    $limit
     * @param int    $skip
     *
     * @return Video[]
     */
    public function get(string $channelId, int $limit, int $skip): array;

    public function getOne(string $id): Video;

    public function add(Video $video): void;

    public function update(Video $video): void;

    public function delete(Video $video): void;

    public function deleteAllByChannel(string $channelId): void;

    public function hasById(string $id): bool;

}