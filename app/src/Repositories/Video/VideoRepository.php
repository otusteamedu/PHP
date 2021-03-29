<?php

namespace App\Repositories\Video;

use App\Entities\Video;
use Illuminate\Support\Collection;

interface VideoRepository
{
    /**
     * @return Collection|Video[]
     */
    public function getAll() : Collection;

    /**
     * @param string $id
     * @return Video
     */
    public function getById(string $id) : Video;

    /**
     * @param string $channelId
     * @return Collection|Video[]
     */
    public function getCollectionByChannelId(string $channelId) : Collection;

    public function withChannel() : self;

    /**
     * @param string $string
     * @param int $offset
     * @param int $limit
     * @return Collection|Video[]
     */
    public function search(string $string, int $offset = 0, int $limit = 100) : Collection;

    /**
     * @param Video $channel
     * @return Video
     */
    public function save(Video $channel) : Video;
}