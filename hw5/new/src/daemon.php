<?php

namespace asterisk;
/**
 * Сервис, слушает события от Asterisk и вызывает соответствующие обработчики
 *
 * @author Petr Ivanov(petr.yrs@gmail.com)
 */

use asterisk\AsteriskAMI;
use Google\Exception;

class daemon
{
    private $server;
    private $port;
    private $user;
    private $pass;
    private $events;
    private $ami;


    /**
     * astDaemon constructor.
     *
     * @param array $params
     *                              server сервер Asterisk
     *                              port порт AMI
     *                              user имя пользователя AMI
     *                              pass пароль
     *                              events массив событий и их обработчиков.
     *                              Например:
     *                              ['Newexten'=>['callback'=>function($data){}]]
     *
     */
    public function __construct($params)
    {
        $this->server = $params['server'];
        $this->port   = $params['port'];
        $this->user   = $params['user'];
        $this->pass   = $params['pass'];
        $this->events = $params['events'];

        $this->ami = new AsteriskAMI($this->server, $this->port, $this->user, $this->pass);
    }


    /**
     * Пересоздать подключение
     */
    public function reInit()
    {
        if ( ! empty($this->ami)) {
            $this->ami->destroy();
        }
        $this->ami = new AsteriskAMI($this->server, $this->port, $this->user, $this->pass);
    }


    /**
     * Вызов обработчика события
     *
     * @param string $eventName Имя события
     * @param mixed  $eventData Данные события
     */
    public function eventDispatcher($eventName, $eventData)
    {
        $eventNames = array_key($this->events);
        if (in_array($eventName, $eventNames)) {
            $event = $this->events[$eventName];
            if (isset($event['callback']) && is_callable($event['callback'])) {
                call_user_func_array($event['callback'], [$eventData]);
            }
        }
    }


    /**
     * Основная функция демона
     */
    public function worker()
    {
        if ($this->ami->connected()) {
            while (true) {
                $data      = $this->ami->read();
                $eventName = array_shift($data);
                $this->eventDispatcher($eventName, $data);
            }
        }
    }


    public function run()
    {
        if ( ! function_exists('pcntl_fork')) {
            throw new Exception('PCNTL functions not available on this PHP installation');
        }

        $pid = \pcntl_fork();

        if ($pid == -1) {
            throw new Exception("Cannt forked\n");
        } elseif ($pid) {
            \pcntl_waitpid($pid, $status);
            if ($status > 0) {
                throw new Exception("Process stoped with code: $status \n");
            }
        } else {
            $this->worker();
        }
    }
}

$params = [
    'server' => '127.0.0.1',
    'port'   => 5080,
    'user'   => 'amiuser',
    'pass'   => 'amipass',
    'events' => [
        'Newexten' => [
            'callback' => function ($data) {
                echo "New call \n";
                print_r($data);
            },
        ],
    ],
];
include 'ami.php';
$server = new daemon($params);
$server->run();
