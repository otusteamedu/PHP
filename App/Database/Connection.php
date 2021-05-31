<?php


namespace App\Database;



use PDO;

//TMP class
abstract class Connection
{
    private static ?iConnection $instance = null;

    public const TYPES = [
//        'sqlite' => SQLiteConnection::class,
        //not realized yey
        'mysql'  => 'mysql',
        'pgsql'  => PostgreSqlConnection::class
    ];


    public function __construct(PDO $PDO)
    {
        $this->connection = $PDO;
    }


    public static function getInstance(): iConnection
    {
        if(is_null(self::$instance)) {
            $type = self::TYPES[getenv('DB_DRIVER')];
            if (empty($type)) {
                throw new \Exception("Wrong database type [$type]");
            }

            $params = [
                'host' => getenv('DB_HOST'),
                'database' => getenv('DB_NAME'),
                'port' => getenv('DB_PORT'),
                'user' => getenv('DB_USER'),
                'password' => getenv('DB_PASSWORD')
            ];
            self::$instance = $type::create($params);
        }
        return  self::$instance;
    }
}