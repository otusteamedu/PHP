<?php


namespace App\Service\Session;



interface SessionInterface
{
    public function start();
    public function close();
    public function write(string $key, $data);
    public function delete(string $key);

    /** @return array|mixed|null */
    public function read(string $key);

}
