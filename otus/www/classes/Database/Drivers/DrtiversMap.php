<?php


namespace Classes\Database\Drivers;


interface DriversMap
{
    public const DB_DRIVERS = [
        'pgsql' => PostgresPdoDriver::class
    ];
}
