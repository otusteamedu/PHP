<?php

namespace Models\Users;

class User
{
    /**
     * @var int|null
     */
    private ?int $id;

    /**
     * @var string
     */
    private string $login;

    /**
     * @var string
     */
    private string $password;

    /**
     * @var string|null
     */
    private ?string $hash;

    public function __construct(
        ?int $id,
        string $login,
        string $password,
        ?string $hash = null
    )
    {
        $this->id = $id;
        $this->login = $login;
        $this->password = $password;
        $this->hash = $hash;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getHash(): ?string
    {
        return $this->hash;
    }

    /**
     * @param string|null $hash
     */
    public function setHash(?string $hash): void
    {
        $this->hash = $hash;
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
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
}