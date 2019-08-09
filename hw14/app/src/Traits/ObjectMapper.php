<?php
/**
* Trait for object mapper
*
* @author Evgeny Prokhorov <prohorov-evgen@ya.ru>
*/
namespace Jekys\Traits;

use Jekys\Main\IdentityMap;

trait ObjectMapper
{
    /**
    * Returns object mapper instance
    *
    * @return object
    */
    private static function mapper(): object
    {
        return IdentityMap::getInstance();
    }
}
