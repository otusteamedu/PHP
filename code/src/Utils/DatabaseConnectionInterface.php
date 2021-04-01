<?php


namespace App\Utils;


interface DatabaseConnectionInterface
{
    public function getDsn(): string;
}
