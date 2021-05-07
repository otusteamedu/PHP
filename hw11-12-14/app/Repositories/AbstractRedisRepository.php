<?php

namespace App\Repositories;

use App\Models\BaseModel;
use App\Clients\RedisClient;
use App\Exceptions\ModelAlreadyExists;
use App\Exceptions\FailToWriteModelToRedis;
use App\Exceptions\FailToDeleteRecordFromRedis;

class AbstractRedisRepository  implements CUDRepositoryInterface
{
    /**
     * @var RedisClient
     */
    protected RedisClient $client;

    /**
     * AbstractElasticRepository constructor.
     */
    public function __construct(RedisClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param BaseModel $model
     *
     * @throws FailToWriteModelToRedis
     * @throws ModelAlreadyExists
     */
    public function insert(BaseModel $model): void
    {
        $id = bin2hex(openssl_random_pseudo_bytes(10));
        $model->setId($id);

        $prefix = $model->getPrefix();
        $suffix = $model->getName();
        $redisKey = "{$prefix}:{$suffix}";

        if ($this->checkIfModelExists($redisKey))
            throw new ModelAlreadyExists();

        if(!$this->client->set($redisKey, serialize($model)))
            throw new FailToWriteModelToRedis();
    }

    /**
     * @param BaseModel $model
     *
     * @throws FailToDeleteRecordFromRedis
     */
    public function delete(BaseModel $model): void
    {
        $prefix = $model->getPrefix();
        $suffix = $model->getName();
        $redisKey = "{$prefix}_{$suffix}";

        if(!$this->client->del($redisKey, serialize($model)))
            throw new FailToDeleteRecordFromRedis();
    }

    /**
     * @param string $key
     * @return bool
     */
    private function checkIfModelExists(string $key): bool
    {
        return !! $this->client->exists($key);
    }
}
