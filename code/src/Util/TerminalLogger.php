<?php


namespace App\Util;


class TerminalLogger
{
    public function log(\Exception $e, $date = false)
    {
        error_log(print_r($e, TRUE));
    }

}
