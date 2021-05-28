<?php


namespace App\Service\Security;


use App\Entity\User;
use App\Service\Storage\SessionStorageInterface;
use Doctrine\ORM\EntityManagerInterface;

class SecurityService implements SecurityInterface
{
    const IDENTITY_KEY = 'identity';

    private SessionStorageInterface $sessionStorage;
    private EntityManagerInterface $entityManager;

    /**
     * SecurityService constructor.
     * @param \App\Service\Storage\SessionStorageInterface $sessionStorage
     */
    public function __construct(
        SessionStorageInterface $sessionStorage, EntityManagerInterface $entityManager
    )
    {
        $this->sessionStorage = $sessionStorage;
        $this->entityManager = $entityManager;
    }


    public function login(string $email, string $password): bool
    {
        $user = $this->getUser($email);

        if (!$user) {
            return false;
        }

        if ($this->checkPassword($user, $password)) {
            $this->sessionStorage->set(self::IDENTITY_KEY, $user->getEmail());
            return true;
        }

        return false;
    }

    public function getIdentity(): ?User
    {
        $email = $this->sessionStorage->get(self::IDENTITY_KEY);
        if (!$email) {
            return null;
        }

        return $this->getUser($email);
    }

    private function getUser(string $email): ?User
    {
        /** @var User $user */
        $user = $this->entityManager
            ->getRepository(User::class)
            ->findOneBy(['email' => $email]);

        if (!$user) {
            return null;
        }

        return $user;
    }

    public function logout(): void
    {
        $this->sessionStorage->clear(self::IDENTITY_KEY);
    }

    public function cryptPassword(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    private function checkPassword(User $user, string $password): bool
    {
        return password_verify($password, $user->getPassword());
    }
}
