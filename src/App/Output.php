<?php


namespace App;


class Output
{

    /**
     * @param string $str
     */
    public function write(string $str)
    {
        echo $str;
    }

    /**
     * @param string $str
     */
    public function writeLn(string $str)
    {
        $this->write($str . '\n');
    }
}