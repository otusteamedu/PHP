<?php

namespace App\Domain;

use Redis;

class Task
{
    public const STATUS_NOT_FOUND = 'not_found';
    public const STATUS_QUEUE = 'queue';
    public const STATUS_DONE = 'done';
    public const STATUS_ERROR = 'error';

    protected Publisher $pub;
    protected Redis $redis;

    public function __construct(Publisher $pub, Redis $redis)
    {
        $this->pub = $pub;
        $this->redis = $redis;
    }

    /**
     * @param mixed $data
     * @return string task id
     * @throws \InvalidArgumentException
     */
    public function set($data): string
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $id = bin2hex(random_bytes(16));
        $this->pub->publish($id, $data);
        $this->redis->hSet($id, 'status', static::STATUS_QUEUE);
        return $id;
    }

    public function get(string $id): array
    {
        $result = $this->redis->hGetAll($id);
        if (!$result) {
            return ['status' => static::STATUS_NOT_FOUND];
        }
        $this->redis->del($id);
        return $result;
    }
}
