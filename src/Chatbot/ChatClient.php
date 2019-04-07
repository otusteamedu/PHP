<?php
namespace Chatbot;

class ChatClient 
{ 
    private $address = '';
    private $port = '';
        
    public function __construct ($address, $port) 
    {
	$this->address = $address;
        $this->port = $port;
    }
                                    
    public function client() 
    {

	echo "Connect to " . $this->address . ":" . $this->port . "\n";

	$socket = new Socket();
	
	$sock = $socket->socketCreate();
	if (!$sock) { 
	    echo $socket->socketMsg($sock) . PHP_EOL; 
	    return false; 
	}

	$isConnect = $socket->socketConnect($sock, $this->address, $this->port);
        if (!$isConnect) { 
    	    echo "Connect failed: " . $socket->socketMsg($sock) . PHP_EOL; 
    	    return false; 
    	}

	$buf = socket_read($sock, 2048);
	if (!$buf) {
	    return false;
	}
        echo $buf . "\n";

	do {

	    $msg = readline("Tell: ");
	    
	    if (trim($msg) != "") {
		socket_write($sock, $msg, strlen($msg));
		if ($msg == 'quit') {
		    break;
		}
	    } else {
		continue;
	    }
	    
	    socket_read($sock, 2048);
	    
    	    echo PHP_EOL;
	  
	} while (true);

        socket_close($sock);
    }
}
