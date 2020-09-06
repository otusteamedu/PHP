<?php


namespace App;


class ConsoleLog extends AbstractLog
{

    public function INFO($msg)
    {
        echo 'INFO: ' . $msg . PHP_EOL;
    }

    public function WARNING($msg)
    {
        echo 'WARNING: ' . $msg . PHP_EOL;
    }

    public function ERROR($msg)
    {
        echo 'ERROR: ' . $msg . PHP_EOL;
    }
}