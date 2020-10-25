<?php

namespace helper;
/**
 * Class SocketHelper
 *
 * @package helper
 * @author  Petr Ivanov (petr.yrs@gmail.com)
 */
class SocketServer extends AbstractSocket
{
    private $connection;

    /**
     * SocketHelper constructor.
     *
     * @param string $conStr путь к файлу сокета
     */
    public function __construct($conStr)
    {
        if (substr($conStr, 0, 4) == 'unix') {
            $fileName = substr($conStr, 7);
            if (file_exists($fileName)) {
                unlink($fileName);
            }
        }
        $this->socket = stream_socket_server($conStr, $errno, $errstr);
        if (empty($this->socket)) {
            new \Exception(( ! empty($errstr)) ? $errstr : sprintf('Не могу подключиться к %s - %s', $conStr, $errstr));
        }
    }


    /**
     * Получить сообщение
     *
     * @return string
     */
    public function read()
    {
        $this->buffer = '';

        //$con = stream_socket_accept($this->socket, 1);
        //do {
        //    $this->buffer .= stream_get_line($con, 1024, "\n");
        //    $metadata = stream_get_meta_data($con);
        //    print_r([
        //        'server read ' =>$this->buffer,
        //        'meta' => $metadata
        //    ]);
        //} while (!feof($con) && $metadata['unread_bytes'] > 0);

        //while ($con = stream_socket_accept($this->socket, 1)) {
        //    $this->buffer .= stream_get_line($con, 1024, "\n");
        //}
        //$this->buffer .= stream_get_line($this->socket, 10);

        //print_r($this->buffer);
        //$con = stream_socket_accept($this->socket, 0);
        //while ( ! feof($this->socket)) {
        //    $this->buffer .= fgets($this->socket);
        //}

        return $this->buffer;
    }


    /**
     * Отправить сообщение
     *
     * @param string $msg сообщение
     *
     * @return false|int
     */
    public function write($msg)
    {
        $con = stream_socket_accept($this->socket);
        if ($con) {
            fwrite($con, $msg);
            fclose($con);
        }
    }
}