<?php

namespace App\Entity;


use DateTime;
use Doctrine\ORM\Mapping as ORM;
use OpenApi\Annotations as OA;



/**
 *
 * @author Alexandr Timofeev <tim31al@gmail.com>
 *
 *
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @ORM\HasLifecycleCallbacks()
 *
 * @OA\Schema ()
 *
 */
class User implements \JsonSerializable
{
    /**
     * User constructor.
     */
    public function __construct()
    {

    }

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     *
     * @OA\Property(property="id", type="integer", description="ID пользователя", example="123")
     */
    protected int $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @OA\Property(property="username", type="string", description="Имя пользователя", example="Иван")
     */
    protected string $firstname;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     * @OA\Property(property="email", type="string", description="email пользователя", example="user@example.com")
     */
    protected string $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected string $password;

    /**
     * @ORM\Column(type="datetime")
     * @OA\Property(property="createdAt", type="datetime", description="Дата, время создания пользователя", example="2021-05-05Т20:31:45")
     */
    protected DateTime $createdAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, unique=true)
     */
    protected ?string $token;


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }


    /**
     * @param string $firstname
     * @return \App\Entity\User
     */
    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;
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
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }


    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAt(): void
    {
        $this->createdAt = new DateTime();
    }


    public function getUsername(): string
    {
        return $this->firstname;
    }

    /**
     * @return string
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }


    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'username' => $this->getUsername(),
            'email' => $this->getEmail(),
            'token' => $this->getToken(),
            'created_at' => $this->getCreatedAt()->format(DATE_ATOM),
        ];
    }
}
