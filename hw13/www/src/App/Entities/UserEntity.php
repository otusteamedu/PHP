<?php

namespace App\Entities;

class UserEntity extends BaseEntity
{
    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $username;
    /**
     * @var string
     */
    protected $firstName;
    /**
     * @var string
     */
    protected $lastName;
    /**
     * @var string|null
     */
    protected $city;
    /**
     * @var string
     */
    protected $createdAt;
    /**
     * @var string|null
     */
    protected $updatedAt;
    /**
     * @var string
     */
    protected $password;

    /**
     * UserEntity constructor.
     * @param int $id
     * @param string $username
     * @param string $firstName
     * @param string $lastName
     * @param string $city
     * @param string $createdAt
     * @param string|null $updatedAt
     * @param string $password
     */
    public function __construct(
        string $username,
        string $firstName,
        string $lastName,
        string $city,
        string $createdAt,
        ?string $updatedAt,
        string $password
    ) {
        $this->username = $username;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->city = $city;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->password = $password;
    }

    /**
     * @param array $state
     * @return UserEntity
     */
    public static function fromState(array $state): UserEntity
    {
        // validate state before accessing keys!

        return new self(
            $state["id"],
            $state['username'],
            $state["firstName"],
            $state["lastName"],
            $state["city"],
            $state["createdAt"],
            $state["updatedAt"],
            $state["password"]
        );
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return self
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return self
     */
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return self
     */
    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return self
     */
    public function setCity(string $city): self
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @param string $createdAt
     * @return self
     */
    public function setCreatedAt(string $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    /**
     * @param string|null $updatedAt
     * @return self
     */
    public function setUpdatedAt(?string $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
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
     * @return self
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }
}