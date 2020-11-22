<?php


namespace App;


abstract class AbstractLog
{
    abstract public function INFO($msg);
    abstract public function WARNING($msg);
    abstract public function ERROR($msg);
    public function closeLog(){}
}