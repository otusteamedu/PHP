<?php


namespace App\Services\Youtube\Repositories\Statistics;


use Illuminate\Support\Collection;

interface ViewChannelRepository
{
    /**
     * Возвращает общее количество просмотров по всем видео для канала
     *
     * @param int $channelId
     * @return int
     */
    public function getViewsCount(int $channelId): int;

    /**
     * Возвращает количество комментариев по всем видео для Канала
     *
     * @param int $channelId
     * @return int
     */
    public function getCommentsCount(int $channelId): int;

    /**
     * Возвращает количество лайков по всем видео для Канала
     *
     * @param int $channelId
     * @return int
     */
    public function getLikesCount(int $channelId): int;

    /**
     * Возвращает количество дизлайков по всем видео для Канала
     *
     * @param int $channelId
     * @return int
     */
    public function getDislikesCount(int $channelId): int;

    /**
     * Достает и возвращает коллекцию Топ $number каналов из ElasticSearch
     * Условие для попадания в топ - сумаа по всем видео с лучшим соотношением Likes/Dislikes для каждого видео
     * @param int $number
     * @return Collection
     */
    public function getTopChannels(int $number): Collection;
}
