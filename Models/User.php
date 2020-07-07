<?php

namespace App\Models;

class User extends ActiveRecord
{
    /** @var string */
    protected $nickname;

    /** @var string */
    protected $email;

    /** @var int */
    protected $isConfirmed;

    /** @var string */
    protected $role;

    /** @var string */
    protected $passwordHash;

    /** @var string */
    protected $authToken;

    /** @var string */
    protected $createdAt;

    /**
     * @return string
     */
    public function getNickname(): string
    {
        return $this->nickname;
    }

    protected static function getTableName(): string
    {
        return 'users';
    }

    public static function signUp(array $userData): User
    {
        if (empty($userData['nickname'])) {
            throw new \Exception('Не передан nickname');
        }

        if (!preg_match('/[a-zA-Z0-9]+/', $userData['nickname'])) {
            throw new \Exception('Nickname может состоять только из символов латинского алфавита и цифр');
        }

        if (empty($userData['email'])) {
            throw new \Exception('Не передан email');
        }

        if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
            throw new \Exception('Email некорректен');
        }

        if (empty($userData['password'])) {
            throw new \Exception('Не передан password');
        }

        if (mb_strlen($userData['password']) < 8) {
            throw new \Exception('Пароль должен быть не менее 8 символов');
        }
        if (static::findOneByColumn('nickname', $userData['nickname']) !== null) {
            throw new \Exception('Пользователь с таким nickname уже существует');
        }

        if (static::findOneByColumn('email', $userData['email']) !== null) {
            throw new \Exception('Пользователь с таким email уже существует');
        }
        $user = new User();
        $user->nickname = $userData['nickname'];
        $user->email = $userData['email'];
        $user->passwordHash = password_hash($userData['password'], PASSWORD_DEFAULT);
        $user->isConfirmed = false;
        $user->role = 'user';
        $user->authToken = sha1(random_bytes(100)) . sha1(random_bytes(100));
        $user->save();

        return $user;
    }

    public function activate(): void
    {
        $this->isConfirmed = true;
        $this->save();
    }

    public static function login(array $loginData): User
    {
        if (empty($loginData['email'])) {
            throw new \Exception('Не передан email');
        }

        if (empty($loginData['password'])) {
            throw new \Exception('Не передан password');
        }

        $user = User::findOneByColumn('email', $loginData['email']);
        if ($user === null) {
            throw new \Exception('Нет пользователя с таким email');
        }

        if (!password_verify($loginData['password'], $user->getPasswordHash())) {
            throw new \Exception('Неправильный пароль');
        }

        if (!$user->isConfirmed) {
            throw new \Exception('Пользователь не подтверждён');
        }

        $user->refreshAuthToken();
        $user->save();

        return $user;
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    public function refreshAuthToken()
    {
        $this->authToken = sha1(random_bytes(100)) . sha1(random_bytes(100));
    }
}