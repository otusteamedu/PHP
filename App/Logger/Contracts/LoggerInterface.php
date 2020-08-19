<?php 

namespace Logger\Contracts;

interface LoggerInterface 
{
    public static function logToFile(string $filename,string $log);
}