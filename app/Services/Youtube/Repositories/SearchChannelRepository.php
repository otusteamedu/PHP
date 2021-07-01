<?php


namespace App\Services\Youtube\Repositories;


use App\Models\Channel;
use Illuminate\Support\Collection;

interface SearchChannelRepository
{
    /**
     * Возвращает коллекцию из 'Channel', где есть совпадения по параметру $q
     * в полях 'title' и 'description' в таблице 'channels'
     * @param string $q
     * @param int $limit
     * @param int $offset
     * @return Collection
     */
    public function search(string $q, int $limit, int $offset): Collection;

    /**
     * Возвращает канал с id = $id
     *
     * @param int $id
     * @return Channel
     */
    public function getChannelById(int $id): Channel;
}
