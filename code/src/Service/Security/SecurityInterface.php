<?php


namespace App\Service\Security;


use App\Entity\User;

interface SecurityInterface
{
    public function login(string $email, string $password): bool;
    public function getIdentity(): ?User;
    public function logout(): void;
    public function cryptPassword(string $password): string;
}
