<?php
namespace Chatbot;

class ChatServer 
{ 
    private $address = '';
    private $port = '';
    
    public function __construct ( $address, $port ) 
    {
          $this->address = $address;
          $this->port = $port;
    }
    
    public function server() 
    {

	echo "Listen: " . $this->address . ":" . $this->port . "\n\n";
	    
	// Загружаем словарь
        $dictObj = new dictionary();
    
        set_time_limit(0);
	ob_implicit_flush();

	$socket = new socket();
	
	$sock = $socket->socketCreate();
	if (!$sock) echo "Error: ". $socket->socketMsg($sock) . "\n";
	
	$isBind = $socket->socketBind($sock, $this->address, $this->port);
	if (!$isBind) echo "Port " . $port . " " . $socket->socketMsg($sock) . "\n";

	$isListen = $socket->socketListen($sock, 5);
	if (!$isListen) echo $socket->socketMsg($sock) . "\n";

	do {

	    $msgsock = $socket->socketAccept($sock);
	    if (!$msgsock) {
    		echo "Не удалось выполнить socket_accept(): причина: " . $socket->socketMsg($sock) . "\n";
	        break;
	    }

    	    /* Welcome msg */
	    $msg = "\n" . "Welcome to Chatbot server!\n\n'quit' - exit from server. 'close' - server shutdown\n";
    	    socket_write($msgsock, $msg, strlen($msg));
    	    
    	    do {

		$buf = socket_read($msgsock, 2048);
    		if (!$buf || $buf == 'quit') break 1;

        	if ($buf == 'close') {
            	    $msg = "bye...\n\n";
            	    socket_write($msgsock, $msg, strlen($msg));
            	    socket_close($msgsock);
            	    echo $buf;
            	    break 2;
    		}

		$ok = 0;

		foreach ( $dictObj->dict as $val ) {
		    $sstr = $val[0];
		    $strfind =  '/(.*?)' . $sstr . '(.*?)/i';
		    if (preg_match($strfind, $buf)) {
			$buf = $val[1];
			$ok = 1;
			break;
		    }
		}
		
		if ($ok === 0) {
		    $buf = $dictObj->default;
		}
				
        	socket_write($msgsock, $buf, strlen($buf));
		echo "Client ($msgsock): ". $buf . "\n";
        	
    	    } while (true);
    	    
	    socket_close($msgsock);
	    
	} while (true);
	
	socket_close($sock);
	
    }
}