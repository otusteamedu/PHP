<?php


namespace AYakovlev\Model;


class User extends ActiveRecordEntity
{
    protected string $nickname;
    protected string $email;
    protected bool   $isConfirmed;
    protected string $role;
    protected string $passwordHash;
    protected string $authToken;
    protected string $createdAt;

    public function getNickname(): string
    {
        return $this->nickname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    protected static function getTableName(): string
    {
        return 'users';
    }
}