<?php
/**
* Singletone realization for Redis connection
*
* @author Evgeny Prokhorov <prohorov-evgen@ya.ru>
*/
namespace Jekys;

class Redis
{
    /**
    * @var self - stores and provide instance for the getInstance() method
    */
    private static $instance;

    /**
    * @var \Redis - stores redis connection
    */
    private $connection;

    /**
     * Hidden constructor, only callable from within this class
     *
     * @param string $redisHost
     * @param string $redisPort
     *
     * @return void
     */
    private function __construct($redisHost = 'redis', $redisPort = 6379)
    {
        $this->connection = new \Redis();
        if (!$this->connection->connect($redisHost, $redisPort)) {
            throw new \Exception('Can`t connect to the redis server');
        }
    }

    /**
     * Create an instance if it hasn't been already
     * Then return the instance of this class
     *
     * @return self
     */
    public static function getInstance(): Redis
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        // return an instance of this class (Database)
        return self::$instance;
    }

    /**
    * Call \Redis methods through this object
    *
    * @param string $method - \Redis object method
    * @param array $args - \Redis object method arguments
    *
    * @return mixed
    */
    public function __call(string $method, array $args)
    {
        return call_user_func_array(
            [
                $this->connection,
                $method
            ],
            $args
        );
    }

    /**
     * Hidden magic clone method, make sure an instance this class
     * cannot be cloned using the clone keyword
     */
    private function __clone()
    {
    }
}
