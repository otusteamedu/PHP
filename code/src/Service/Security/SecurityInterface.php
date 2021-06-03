<?php


namespace App\Service\Security;


use App\Entity\User;

interface SecurityInterface
{
    public function login(string $email, string $password): ?string;
    public function getIdentity(string $token): ?User;
    public function cryptPassword(string $password): string;
}
