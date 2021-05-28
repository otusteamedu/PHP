<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @ORM\HasLifecycleCallbacks()
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected int $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected string $firstname;
    /**
     * @ORM\Column(type="string", length=100, unique=true)
     */
    protected string $email;
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected string $password;



    /**
     * @ORM\Column(type="datetime")
     */
    protected DateTime $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected DateTime $lastVisit;


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

    /**
     * @return DateTime
     */
    public function getLastVisit(): DateTime
    {
        return $this->lastVisit;
    }

    /**
     * @param DateTime $lastVisit
     */
    public function setLastVisit(DateTime $lastVisit): self
    {
        $this->lastVisit = $lastVisit;
        return $this;

    }

    public function getUsername(): string
    {
        return $this->firstname;
    }
}
