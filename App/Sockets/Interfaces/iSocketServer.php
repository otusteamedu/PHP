<?php


namespace App\Sockets\Interfaces;


interface iSocketServer extends iSocketBase
{
    public function create(): iSocketServer;

    public function connect(): iSocketServer;

    public function bind(): iSocketServer;

    public function listen(): iSocketServer;

    public function accept(): iSocketServer;

    public function accepted(): iSocketConnected;
}