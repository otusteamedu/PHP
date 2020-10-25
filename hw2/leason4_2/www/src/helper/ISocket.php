<?php

namespace helper;

interface ISocket
{
    public function read();


    public function write($msg);


    public function isConnected();
}