<?php

declare(strict_types=1);

namespace App\Model\Channel\Repository;

use App\Model\Channel\Entity\Channel;

interface ChannelRepositoryInterface
{

    /**
     * @param int $limit
     * @param int $skip
     *
     * @return Channel[]
     */
    public function get(int $limit, int $skip): array;

    public function getOne(string $id): Channel;

    public function add(Channel $channel): void;

    public function update(Channel $channel): void;

    public function delete(Channel $channel): void;

    public function hasById(string $id): bool;

}