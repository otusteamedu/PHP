<?php


namespace Repetitor8\Application\Routers;


interface IRouter
{
    public static function run(int $argvNumber = 1): void;
}