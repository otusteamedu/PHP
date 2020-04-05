<?php

namespace Bjlag;

use Bjlag\Db\Store;

class App
{
    /** @var \Bjlag\Db\Store */
    private static $db = null;

    public function run(): void
    {
        try {
            $data = self::getDb()->find('channel', ['name', 'source'], ['source' => 'app']);
            var_dump($data);
        } catch (\Throwable $e) {
            var_dump($e->getMessage());
            var_dump($e->getTrace());
        }
    }

    /**
     * @return \Bjlag\Db\Store
     */
    public static function getDb(): Store
    {
        if (self::$db === null) {
            $uri = 'mongodb://dev:dev@mongo:27017';
            $dbName = 'youtube';
            $dbAdapter = 'MongoDb';
            $adapterClass = '\\Bjlag\\Db\\Adapters\\' . $dbAdapter;

            /** @var \Bjlag\Db\Store $adapter */
            $adapter = (new $adapterClass());
            self::$db = $adapter->getConnection($uri, $dbName);
        }

        return self::$db;
    }
}
