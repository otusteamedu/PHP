<?php
namespace Paa\Models;

use Paa\App\RabbitController;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitModel extends RabbitController
{
    public function __construct() 
    {
        $this->connect = parent::__construct();
        $this->channel = $this->connect->channel();
    }

    public function __destruct() 
    {
        $this->channel->close();
        $this->connect->close();
    }

    public function sendMess(string $msg = '')
    {
	if ($msg != '') {
	    $this->channel->queue_declare('feedback', false, false, false, false);
	    $msgText = new AMQPMessage($msg);
	    $this->channel->basic_publish($msgText, '', 'feedback');
	} 
    }

    public function receiveMess() 
    {

	$this->channel->queue_declare('feedback', false, false, false, false);
	
	$callback = function ($msg) {
	    $this->response = $msg->body;
	};
	$this->response = null;
	$this->channel->basic_consume('feedback', '', false, true, false, false, $callback);
	$this->channel->wait();
	return $this->response;
    }
    


}
