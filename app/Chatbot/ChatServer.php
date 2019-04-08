<?php
namespace Chatbot;

class ChatServer 
{ 
    private $address = '';
    private $port = '';
    
    public function __construct ($address, $port)
    {
          $this->address = $address;
          $this->port = $port;
    }
    
    public function server() 
    {

	echo "Listen: " . $this->address . ":" . $this->port . PHP_EOL . PHP_EOL;
	    
	// Загружаем словарь
        $dictObj = new Dictionary();
    
        set_time_limit(0);
	ob_implicit_flush();

	$socket = new Socket();
	
	$sock = $socket->socketCreate();
	if (!$sock) {
	    echo "Error: ". $socket->socketMsg($sock) . PHP_EOL;
	}
	
	$isBind = $socket->socketBind($sock, $this->address, $this->port);
	if (!$isBind) {
	    echo "Port " . $port . " " . $socket->socketMsg($sock) . PHP_EOL;
	}

	$isListen = $socket->socketListen($sock, 5);
	if (!$isListen) {
	    echo $socket->socketMsg($sock) . PHP_EOL;
	}

	do {

	    $msgsock = $socket->socketAccept($sock);
	    if (!$msgsock) {
    		echo "Не удалось выполнить socket_accept(): причина: " . $socket->socketMsg($sock) . PHP_EOL;
	        break;
	    }

    	    /* Welcome msg */
	    $msg = PHP_EOL . "Welcome to Chatbot server!" . PHP_EOL . PHP_EOL . "'quit' - exit from server. 'close' - server shutdown" . PHP_EOL;;
    	    socket_write($msgsock, $msg, strlen($msg));
    	    
    	    do {
		$buf = socket_read($msgsock, 2048);
    		if (!$buf || $buf == 'quit') {
    		    break 1;
    		}

        	if ($buf == 'close') {
            	    $msg = "bye..." . PHP_EOL . PHP_EOL;
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
		echo "Client ($msgsock): ". $buf . PHP_EOL;;
        	
    	    } while (true);
    	    
	    socket_close($msgsock);
	    
	} while (true);
	
	socket_close($sock);
	
    }
}