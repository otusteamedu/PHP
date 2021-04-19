<?php

namespace App\Repositories\Channel;

use App\Entities\Channel;
use Illuminate\Support\Collection;

interface ChannelRepository
{
    /**
     * @return Collection|Channel[]
     */
    public function getAll() : Collection;

    /**
     * @param string $id
     * @return Channel
     */
    public function getById(string $id) : Channel;

    public function withVideos() : self;

    public function withVideoStatistics() : self;

    /**
     * @param string $string
     * @param int $offset
     * @param int $limit
     * @return Collection|Channel[]
     */
    public function search(string $string, int $offset = 0, int $limit = 100) : Collection;

    /**
     * @param Channel $channel
     * @return Channel
     */
    public function save(Channel $channel) : Channel;
}