<?php

namespace App\DB;

use \PDO;

/**
 * Class Db
 * @package App\DB
 */
class Db
{
    /**
     *
     * @var PDO
     */
    private static $pool;

    /**
     *
     * @return PDO
     */
    public static function get(): PDO
    {
        return self::$pool ?? self::$pool = self::connect(self::getConfig());
    }

    /**
     *
     * @param  array $config
     * 
     * @throws \RuntimeException
     * @return PDO
     */
    private static function connect(array $config): PDO
    {
        try {
            return new PDO($config['dsn'], $config['username'], $config['password']);
        } catch (\PDOException $e) {
            $message = $e->getMessage();
            throw new \RuntimeException("Не может подключиться '{$config['dsn']}'. {$message}");
        }
    }

    /**
     * 
     * @throws \RuntimeException
     * @return array
     */
    private static function getConfig(): array
    {
        return [
            'dsn'      => getenv('DB_CONNECTION'). ':host='.getenv('DB_HOST').';port='.getenv('DB_PORT').';dbname='.getenv('DB_DATABASE'),
            'username' => getenv('DB_USERNAME'),
            'password' => getenv('DB_PASSWORD'),
        ];
    }


    public static function generateData()
    {
        $db = self::get();
        $db->exec("CREATE TABLE posts (id SERIAL PRIMARY KEY, title VARCHAR(512), text VARCHAR(512), category_id INT(11));");
        $db->exec("CREATE TABLE categories (id SERIAL PRIMARY KEY, title VARCHAR(512));");
        $db->exec("INSERT INTO categories (title) VALUES ('Категория')");
        $db->exec("INSERT INTO posts (title, text, category_id) VALUES ('Заголовок', 'Текст', 1)");

    }
}
