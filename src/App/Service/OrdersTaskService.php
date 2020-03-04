<?php

namespace App\Service;

use App\Core\Environment;
use App\Core\MqConnector;
use AMQPChannel;
use AMQPConnection;
use AMQPExchange;
use AMQPQueue;
use App\Core\RedisConnector;
use Exception;
use GuzzleHttp\Client;
use Redis;

class OrdersTaskService
{
    private const CALC_RES_TTL = 7200;

    private Environment $env;

    private AMQPConnection $amqpConnection;
    private AMQPChannel $channel;
    private AMQPExchange $exchange;
    private AMQPQueue $queue;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->env = new Environment();
    }

    /**
     * @param string $body
     * @param string $queueName
     * @return string
     * @throws Exception
     */
    public function pushTask(string $body, $queueName = ''): string
    {
        $this->initQueueBroker($this->env->getMqConnector(), $queueName);
        $id = uniqid('', true);
        $this->queue->bind($this->exchange->getName(), $id);
        $this->exchange->publish($body, $id);
        $this->amqpConnection->disconnect();
        return $id;
    }

    /**
     * @param string $ticketId
     * @param array  $order
     * @return void
     */
    public function checkTask(string $ticketId, ?array &$order = null)
    {
        $redisClient = $this->initRedisClient($this->env->getRedisConnector());
        if ($redisClient->exists($ticketId)) {
            $order = json_decode($redisClient->get($ticketId));
        }
    }

    /**
     * @param string $queueName
     */
    public function runWorkers(string $queueName)
    {
        try {
            $this->initQueueBroker($this->env->getMqConnector(), $queueName);
            $redisClient = $this->initRedisClient(
                $this->env->getRedisConnector()
            );
            while ($envelope = $this->queue->get()) {
                $this->queue->ack($envelope->getDeliveryTag());
                $formData = [
                    'form_params' => json_decode($envelope->getBody(), true),
                ];
                $httpClient = new Client();
                try {
                    $respBody = $httpClient->request(
                        'POST',
                        $this->env->getOrdersApiUrl() . '/orders/calculate',
                        $formData
                    )->getBody()->__toString();
                    $redisClient->setex(
                        $envelope->getRoutingKey(),
                        self::CALC_RES_TTL,
                        $respBody
                    );
                } catch (Exception $e) {
                }
            }
        } catch (Exception $e) {
        }
    }

    /**
     * @param string      $queueName
     * @param MqConnector $connector
     * @throws Exception
     */
    private function initQueueBroker(MqConnector $connector, string $queueName)
    {
        $this->amqpConnection = new AMQPConnection($connector->toAssoc());
        $this->amqpConnection->connect();
        $this->channel = new AMQPChannel($this->amqpConnection);
        $this->exchange = new AMQPExchange($this->channel);
        $this->exchange->setName($connector->getExchange());
        $this->exchange->setType(AMQP_EX_TYPE_DIRECT);
        $this->exchange->setFlags(AMQP_DURABLE);
        $this->exchange->declare();

        $this->queue = new AMQPQueue($this->channel);
        $this->queue->setName($queueName);
        $this->queue->setFlags(AMQP_IFUNUSED | AMQP_AUTODELETE);
        $this->queue->declare();
    }

    /**
     * @param RedisConnector $connector
     * @return Redis
     */
    private function initRedisClient(RedisConnector $connector): Redis
    {
        $redis = new Redis();
        $redis->connect($connector->getHost(), $connector->getPort());
        $redis->select($connector->getDb());
        return $redis;
    }
}