<?php
	
	$host = "127.0.0.1";
	$port = 9500;
	
	// No Timeout 
	set_time_limit(0);

	//Create Socket
	$sock = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");

	//Bind the socket to port and host
	$result = socket_bind($sock, $host, $port) or die("Could not bind to socket\n");

	while(true) {
		//Start listening to the port
		$result = socket_listen($sock, 3) or die("Could not set up socket listener\n");

		//Make it to accept incoming connection
		$spawn = socket_accept($sock) or die("Could not accept incoming connection\n");

		//Read the message from the client socket
		$input = socket_read($spawn, 1024) or die("Could not read input\n");

		$output = 'I received your message. Now do you job and subscribe to Mossymoo youtube channel!';

		//Send message back to client socket
		socket_write($spawn, $output, strlen ($output)) or die("Could not write output\n");
	}

	socket_close($spawn);
	socket_close($socket);

?>