<?php
namespace App;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Class ReceiverQueueRpcServer
 * @package App
 */
class ReceiverQueueRpcServer{
    /**
     * @var AMQPStreamConnection
     */
    public $connection;
    /**
     * @var \PhpAmqpLib\Channel\AMQPChannel
     */
    public $channel;
    /**
     * @var HttpRequestOrderInsert
     */
    public $queueHttpRequestOrderInsert;

    /**
     * ReceiverQueueRpcServer constructor.
     * @param HttpRequestOrderInsert $HttpRequestOrderInsert
     * @param AMQPStreamConnection $RabbitMQ
     */
    public function __construct(HttpRequestOrderInsert $HttpRequestOrderInsert, AMQPStreamConnection $RabbitMQ)
    {
        $this->queueHttpRequestOrderInsert=$HttpRequestOrderInsert;
        $this->connection= $RabbitMQ;
        $this->channel=$this->connection->channel();
        $this->channel->queue_declare('rpc_queue', false, false, false, false);
        $this->channel->basic_qos(null, 1, null);
        echo " [x] Awaiting RPC requests\n";
        $callback = function ($req) {
            $reqBody=json_decode($req->body,true);

            $msg = new AMQPMessage(
                (string) $this->queueCreateQuery($reqBody),
                array('correlation_id' => $req->get('correlation_id'))
            );
            $req->delivery_info['channel']->basic_publish(
                $msg,
                '',
                $req->get('reply_to')
            );
            $req->delivery_info['channel']->basic_ack(
                $req->delivery_info['delivery_tag']
            );
        };
        $this->channel->basic_consume('rpc_queue', '', false, false, false, false, $callback);

    }

    /**
     * @param $reqBody
     * @return string
     */
    public function queueCreateQuery($reqBody)
    {
        $message=uniqid();
        $this->queueHttpRequestOrderInsert->request($reqBody,$message);
        return $message;

    }


    /**
     * @throws \ErrorException
     */
    public function  queueWait(){

        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }

    }

    /**
     * @throws \Exception
     */
    public function queueClose(){
        $this->channel->close();
        $this->connection->close();

    }


}