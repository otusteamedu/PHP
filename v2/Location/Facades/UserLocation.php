<?php

namespace v2\Location\Facades;

use Illuminate\Support\Facades\Facade;

class UserLocation extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'UserLocation';
    }
}
