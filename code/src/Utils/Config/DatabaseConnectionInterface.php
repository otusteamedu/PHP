<?php


namespace App\Utils\Config;


interface DatabaseConnectionInterface
{
    public function getDsn(): string;
}
