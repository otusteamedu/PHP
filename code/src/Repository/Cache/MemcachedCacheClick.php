<?php


namespace App\Repository\Cache;


use App\Repository\Interfaces\CacheChannelClickInterface;
use Memcached;
use Psr\Container\ContainerInterface;

class MemcachedCacheClick implements CacheChannelClickInterface
{
    const CHANNEL_CACHE_KEY = 'channel:';

    private Memcached $client;

    /**
     * MemcachedCacheClick constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->client = $container->get('memcached');
    }


    public function set(string $channelId): int
    {
        $key = $this->generateKey($channelId);
        if (!$cachedKey = $this->client->get($key)) {
            $this->client->set($key, 0);
        }

        return $this->client->increment($key);
    }

    public function get(string $channelId): int
    {
        $key = $this->generateKey($channelId);
        $this->client->get($key);
    }

    public function delete(string $channelId): void
    {
        $key = $this->generateKey($channelId);
        $this->client->delete($key);
    }

    public function deleteAll(): void
    {
        $keys = $this->client->getAllKeys();
        foreach ($keys as $key) {
            if (false !== strpos($key, self::CHANNEL_CACHE_KEY)) {
                $this->client->delete($key);
            }
        }
    }

    private function generateKey(string $id): string
    {
        return self::CHANNEL_CACHE_KEY . $id;
    }
}
