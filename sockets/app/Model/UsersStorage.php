<?php


namespace App\Model;


use App\Api\StorageInterface;
use Noodlehaus\Config;

class UsersStorage implements StorageInterface
{
    private Config $driver;
    private string $file;

    public function __construct(string $file)
    {
        $this->file = $file;
        $this->driver = new Config($file);
    }


    public function get(string $name)
    {
        return $this->driver->get($name);
    }

    public function set(string $name, $value)
    {
        $this->driver->set($name, $value);
    }

    public function addUser(string $newUser)
    {
        $users = ($usersRaw = $this->get('users')) ? explode(',', $usersRaw) : [];
        $users[] = $newUser;
        $this->set('users', implode(',', array_unique(array_filter($users))));
        $this->save();
    }

    public function save()
    {
        $this->driver->toFile($this->file);
    }
}