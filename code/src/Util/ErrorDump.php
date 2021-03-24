<?php


namespace App\Util;


class ErrorDump
{
    public function dump(\Exception $e)
    {
        echo $e->getMessage(), PHP_EOL;
        echo $e->getFile() . ': ' . $e->getLine(), PHP_EOL;
    }

}
