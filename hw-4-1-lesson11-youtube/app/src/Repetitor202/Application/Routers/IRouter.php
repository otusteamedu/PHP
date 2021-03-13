<?php


namespace Repetitor202\Application\Routers;


interface IRouter
{
    public static function run(int $argvNumber = 1): void;
}