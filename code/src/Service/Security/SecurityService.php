<?php


namespace App\Service\Security;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class SecurityService implements SecurityInterface
{
    const TOKEN_LENGTH = 10;

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * Вход пользователя.
     *
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function login(string $email, string $password): ?string
    {
        /** @var User $user */
        $user = $this->entityManager
            ->getRepository(User::class)
            ->findOneBy(['email' => $email]);

        if (!$user) {
            return null;
        }

        if ($this->checkPassword($user, $password)) {
            $token = bin2hex(random_bytes(self::TOKEN_LENGTH));
            $user->setToken($token);
            $this->entityManager->flush();

            return $token;
        }

        return null;
    }

    /**
     * Возвращает вошедшего пользователя
     *
     * @return \App\Entity\User|null
     */
    public function getIdentity(string $token): ?User
    {
        /** @var User $user */
        $user = $this->entityManager->getRepository(User::class)
            ->findBy(['token' => $token]);

        return $user;
    }


    /**
     * Шифрование пароля.
     *
     * @param string $password
     * @return string
     */
    public function cryptPassword(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Проверка пароля.
     *
     * @param \App\Entity\User $user
     * @param string $password
     * @return bool
     */
    private function checkPassword(User $user, string $password): bool
    {
        return password_verify($password, $user->getPassword());
    }
}
