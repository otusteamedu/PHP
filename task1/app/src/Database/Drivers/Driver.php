<?php


namespace App\Database\Drivers;


interface Driver
{
    public function getConnection($params = null);
}