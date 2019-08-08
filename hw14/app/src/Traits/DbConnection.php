<?php
/**
* Trait for database connection
*
* @author Evgeny Prokhorov <prohorov-evgen@ya.ru>
*/
namespace Jekys\Traits;

use Jekys\Main\Database;

trait DbConnection
{
    /**
    * Returns database connection
    *
    * @return object
    */
    private static function db(): object
    {
        return Database::getInstance();
    }
}
