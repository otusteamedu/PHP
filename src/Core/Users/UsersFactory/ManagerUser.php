<?php

namespace App\Core\Users\UsersFactory;

class ManagerUser extends User
{
    protected array $rules = [
        'accessToAdminPath' => 'true',
        'createOrder' => 'true',
        'createClient' => 'true',
        'deleteProducts' => 'false',
        'addProducts' => 'false',
        'accessLevel' => '2'
    ];

    private string $login;
    private string $passwordHash;

    public function getRules(): array
    {
        return $this->rules;
    }

    public function setRules(array $rules): void
    {
        $this->rules = $rules;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @param string $login
     */
    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    /**
     * @return string
     */
    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    /**
     * @param string $passwordHash
     */
    public function setPasswordHash(string $passwordHash): void
    {
        $this->passwordHash = $passwordHash;
    }


}