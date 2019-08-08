<?php
/**
* Singleton database connection class
*
* @author Evgeny Prokhorov <prohorov-evgen@ya.ru>
*/
namespace Jekys\Main;

use Jekys\Abstraction\Singleton;

class Database extends Singleton
{
    /**
    * @var object - database connection handler
    */
    public $handler;

    /**
    * Protected class object constructor
    * Create a database connection via config values
    *
    * @return void
    */
    protected function __construct()
    {
        $config = Config::getInstance();

        $dsn = 'pgsql:';
        $dsn .= 'dbname='.$config->db_name.';';
        $dsn .= 'host='.$config->db_host.';';
        $dsn .= 'user='.$config->db_user.';';
        $dsn .= 'password='.$config->db_pass;

        $this->handler = new \PDO($dsn);
    }

    /**
    * Translates all method calls to the database handler
    *
    * @param string $method
    * @param array #args
    *
    * @return mixed
    */
    public function __call(string $method, array $args)
    {
        return call_user_func_array(
            [
                $this->handler,
                $method
            ],
            $args
        );
    }
}
