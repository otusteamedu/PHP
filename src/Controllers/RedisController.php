<?php

namespace Controllers;

use Averias\RedisJson\Client\RedisJsonClientInterface;
use Averias\RedisJson\Exception\RedisClientException;
use Averias\RedisJson\Factory\RedisJsonClientFactory;
use Configs\RedisConfig;
use Helpers\Session;

/**
 * Class RedisController
 * @package Controllers
 */
class RedisController
{
    protected RedisJsonClientInterface $redisClient;

    /**
     * RedisController constructor.
     * @throws RedisClientException
     */
    public function __construct()
    {
        $redisJsonClientFactory = new RedisJsonClientFactory();
        $this->redisClient = $redisJsonClientFactory->createClient(RedisConfig::$config);
    }


    public function setEvent(array $arrData): bool
    {
        Session::setCount();
        $result = $this->redisClient->jsonSet('event' . $_SESSION['count'], $arrData);
        return $result === true;
    }

    /**
     * @return array
     */
    public function getAllEvent(): array
    {
        $arrResult = [];
        if (is_int($_SESSION['count'])) {
            for ($i = 0; $i <= $_SESSION['count']; $i++) {
                $arrResult['event' . $i] = $this->redisClient->jsonGet('event' . $i);
            }
            return $arrResult;
        }
        return $arrResult;
    }

    public function getEvent(string $key): array
    {
        return $arrResult[$key] = $this->redisClient->jsonGet($key);
    }

    /**
     * @return array
     */
    public function deleteAllEvent(): array
    {
        $result = [];
        if(is_int($_SESSION['count'])){
            for ($i = 0; $i <= $_SESSION['count']; $i++) {
                $result['event' . $i] = $this->redisClient->jsonDelete('event' . $i);
            }
            return $result;
        }
        return $result;
    }
}