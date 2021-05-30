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

    /**
     * Старт сессии
     */
    public function start()
    {
        list($lifetime, $path, $domain, $security, $httpOnly, $name)
            = array_values($this->container->get('session'));

        session_set_cookie_params($lifetime, $path, $domain, $security, $httpOnly);
        session_name($name);
        session_start();
    }

    /**
     * Закрывает сессию.
     */
    public function close()
    {
        session_write_close();
    }

    /**
     * Получить данные по ключу.
     *
     * @return array|mixed|null
     */
    public function read(string $key)
    {
        return $_SESSION[$key];
    }

    /**
     * Записать данные
     *
     * @param string $key
     * @param $data
     */
    public function write(string $key, $data)
    {
        $_SESSION[$key] = $data;
    }

    /**
     * Удалить данные.
     *
     * @param string $key
     */
    public function delete(string $key)
    {
        unset($_SESSION[$key]);
    }
}
