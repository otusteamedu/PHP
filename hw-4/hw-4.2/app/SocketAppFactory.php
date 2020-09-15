<?php


namespace App;


use App\Exceptions\InvalidInstanceTypeException;

class SocketAppFactory
{
    private int $port;
    private string $host;

    /**
     * SocketAppFactory constructor.
     */
    public function __construct()
    {
        $this->host = $_ENV['SOCKET_PATH'];
        $this->port = $_ENV['SOCKET_PORT'];
    }

    /**
     * @param string $type
     * @return SocketAppContract
     * @throws InvalidInstanceTypeException
     */
    public function createInstance($type = null)
    {
        switch ($type) {
            case 'client':
                return new Client($this->host, $this->port);
            case 'server':
                return new Server($this->host, $this->port);
            default:
                throw new InvalidInstanceTypeException('Invalid instance type');
        }
    }


}
