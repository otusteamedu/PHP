<?php


namespace App\Service\Storage;

use App\Service\Session\SessionInterface;

class SessionStorage implements SessionStorageInterface
{
    private SessionInterface $session;

    /**
     * SessionStorage constructor.
     * @param \App\Service\Session\SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }


    /**
     * Returns the contents of storage
     * @param string|null $key
     * @return array|mixed|null
     */
    public function get(string $key)
    {
        return $this->session->read($key);

    }

    /**
     * Writes $contents to storage
     *
     * @param string $key
     * @param array|mixed $value
     */
    public function set(string $key, $value): void
    {
        $this->session->write($key, $value);
    }

    /**
     * Clears contents from storage
     * @param $key
     */
    public function clear($key): void
    {
        $this->session->delete($key);
    }

    /**
     * @param $key
     * @return bool
     */
    public function has($key): bool
    {
        return $this->session->read($key) !== null;
    }
}
