<?php


namespace App\Sockets\Interfaces;


interface iSocketBase extends iSocketConnected
{
    public function create(): iSocketBase;

    public function connect(): iSocketBase;
}