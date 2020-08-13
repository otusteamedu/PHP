<?php


namespace App\Otus\PatternsAlgorithms\Users;


abstract class User
{
    /**
     * Type of the user (Customer, Admin, etc). Value to be overwritten by child classes.
     *
     * @var string
     */
    protected $type = 'user';

    /**
     * Name of the user.
     *
     * @var string
     */
    private $name;


    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
}