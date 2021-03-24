<?php


namespace App\Util;


class TerminalLogger
{
    public function log($message, $date = false)
    {
        error_log(print_r($message, TRUE));
    }

}
