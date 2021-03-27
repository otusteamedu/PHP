<?php


namespace App\Repository\Cache;


use App\Repository\Interfaces\CacheChannelClickInterface;
use Psr\Container\ContainerInterface;
use Redis;

class RedisCacheClick implements CacheChannelClickInterface
{
    const CHANNEL_CACHE_KEY = 'channel:';
    private Redis $redis;

    /**
     * RedisCacheClick constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->redis = $container->get('redis');
    }


    public function set(string $channelId): int
    {
        $key = $this->generateKey($channelId);
        return $this->redis->incr($key);
    }

    public function get(string $channelId): int
    {
        $key = $this->generateKey($channelId);
        return $this->redis->get($key);
    }

    public function delete(string $channelId): void
    {
        $key = $this->generateKey($channelId);
        $this->redis->del($key);
    }

    public function deleteAll(): void
    {
        $keys = $this->redis->keys(self::CHANNEL_CACHE_KEY . '*');
        $this->redis->del($keys);
    }

    private function generateKey(string $id): string
    {
        return self::CHANNEL_CACHE_KEY . $id;
    }


}
