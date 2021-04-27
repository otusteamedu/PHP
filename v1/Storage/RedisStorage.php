<?php


namespace App\Services\Storage;

use Illuminate\Support\Facades\Cache;

abstract class RedisStorage
{
    protected static $storageName = 'storage';
    protected static $storageTime = 60*24*30*12; //1 year

    public static function save(string $key,  $point)
    {
        $storage = self::getStorage();
        return $storage->put($key, $point, self::$storageTime);
    }

    public static function get($key)
    {
        $storage = self::getStorage();
        return $storage->get($key);
    }

    public static function clearStorage()
    {
        self::getStorage()->flush();
    }

    protected static function getStorage()
    {
        if(config('app.env') === 'testing'){
            return Cache::store('file');
        }

        return Cache::store('redis')->tags([self::$storageName]);
    }
}