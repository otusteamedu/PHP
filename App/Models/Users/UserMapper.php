<?php

namespace Models\Users;

use Controllers\Login\Login;
use Models\Users\User;
use \PDO;
use Controllers\Contracts\UserInterface;

class UserMapper implements UserInterface
{
    /**
     * @var PDO
     */
    private $pdo;

    /**
     * @var bool|\PDOStatement
     */
    private $insertStatement;

    /**
     * @var bool|\PDOStatement
     */
    private $selectStatement;

    /**
     * @var bool|\PDOStatement
     */
    private $updateStatement;

    /**
     * @var bool|\PDOStatement
     */
    private $deleteStatement;

    private $checkUserStatement;
    /**
     * UserMapper constructor.
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;

        $this->selectStatement = $pdo->prepare(
            "SELECT login, password, hash FROM users WHERE id = ?"
        );
        $this->insertStatement = $pdo->prepare(
            "INSERT INTO users (login, password, hash) values (?, ?, ?)"
        );
        $this->updateStatement = $pdo->prepare(
            "UPDATE users SET login = ?, password = ?, hash = ? WHERE id = ?"
        );
        $this->deleteStatement = $pdo->prepare(
            "DELETE FROM users WHERE id = ?"
        );
        $this->checkUserStatement = $pdo->prepare(
            "SELECT id, login, password, hash FROM users WHERE login = ? and password = ?"
        );
    }

    /**
     * @param \Models\Users\User $user
     * @return int
     */
    public function insert(User $user): User
    {
        $this->insertStatement->execute([
            $user->getLogin(),
            $user->getPassword(),
            $user->getHash()
        ]);

        return new User(
            (int) $this->pdo->lastInsertId(),
            $user->getLogin(),
            $user->getPassword(),
            $user->getHash()
        );
    }

    /**
     * @param int $id
     * @return \Models\Users\User
     */
    public function select(int $id): User
    {
        $this->selectStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStatement->execute([$id]);
        $result = $this->selectStatement->fetch();

        if (!$result)
            Throw new \Exception('Такого пользователя не существует');

        return new User(
            $id,
            $result['login'],
            $result['password'],
            $result['hash']
        );
    }

    /**
     * @param \Models\Users\User $user
     * @return bool
     */
    public function update(User $user): bool
    {
        return $this->updateStatement->execute([
            $user->getLogin(),
            $user->getPassword(),
            $user->getHash(),
            $user->getId()
        ]);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->deleteStatement->execute([$id]);
    }

    /**
     * Метод поиска пользователья при авторизации по логину и паролю
     * @param \Models\Users\User $user
     * @return User
     */
    public function checkUser(User $user): User
    {
        $this->checkUserStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->checkUserStatement->execute([
            trim($user->getLogin()),
            trim($user->getPassword())
        ]);
        $result = $this->checkUserStatement->fetch();

        if (!$result) {
            Throw new \Exception(
                sprintf(
                    'Warning: Пользователя с логином %s и паролем %s не существует',
                    $user->getLogin(),
                    $user->getPassword()
                )
            );

            return false;
        }



        return new User(
            $result['id'],
            $result['login'],
            $result['password'],
            $result['hash']
        );

    }
}