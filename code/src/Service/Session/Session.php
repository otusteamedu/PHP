<?php


namespace App\Service\Session;


use Psr\Container\ContainerInterface;

class Session implements SessionInterface
{
    private ContainerInterface $container;


    /**
     * Session constructor.
     * @param \Psr\Container\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function start()
    {
        list($lifetime, $path, $domain, $security, $httpOnly, $name)
            = array_values($this->container->get('session'));

        session_set_cookie_params($lifetime, $path, $domain, $security, $httpOnly);
        session_name($name);
        session_start();
    }

    public function close()
    {
        session_write_close();
    }

    /** @return array|mixed|null */
    public function read(string $key)
    {
        return $_SESSION[$key];
    }

    public function write(string $key, $data)
    {
        $_SESSION[$key] = $data;
    }

    public function delete(string $key)
    {
        unset($_SESSION[$key]);
    }
}
