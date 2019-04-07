<?php
namespace Chatbot;

class Socket 
{ 
    
    function socketCreate() 
    { 
	return @socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    } 
    function socketBind($sock = NULL, $address = NULL, $port = NULL) 
    {
	return @socket_bind($sock, $address, $port);
    }
    function socketListen($sock = NULL, $param = 5) 
    {
	return @socket_listen($sock, $param);
    }
    function socketAccept($sock = NULL) 
    {
	return @socket_accept($sock);
    }
    function socketConnect($sock = NULL, $address = NULL, $port = NULL) 
    {
	return @socket_connect($sock, $address, $port);
    }
    function socketMsg($sock = NULL) 
    {
	return @socket_strerror(socket_last_error($sock));
    }
}