<?php

namespace crazydope\theater\Model;

class User
{
    public const ROLE_GUEST = 'guest';

    public const ROLE_MANAGER = 'manager';
    /**
     * @var array
     */
    protected $access = [];

    public function __construct(array $access)
    {
        $this->access = $access;
    }

    public function isAuthorized(string $identifier): bool
    {
        return in_array($identifier, $this->access,false);
    }
}