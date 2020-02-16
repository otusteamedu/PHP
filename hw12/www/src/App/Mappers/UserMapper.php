<?php

namespace App\Mappers;

use App\Entities\UserEntity;
use App\Framework\MapperException;

class UserMapper extends AbstractMapper
{
    /**
     * @var bool|\PDOStatement
     */
    protected $selectStmtByName;

    /**
     * UserMapper constructor.
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        parent::__construct($pdo);

        $this->selectStmt = $pdo->prepare(
            "select username, first_name, last_name, city, created_at, updated_at, password from public.users where id = ?"
        );
        $this->selectStmtByName = $pdo->prepare(
            "select * from public.users where first_name like ?"
        );
        $this->insertStmt = $pdo->prepare(
            "insert into users (username, first_name, last_name, city, created_at, updated_at, password) values (?, ?, ?, ?, ?, ?, ?)"
        );
        $this->updateStmt = $pdo->prepare(
            "update users set username = ?, first_name = ?, last_name = ?, city = ?, created_at = ?, updated_at = ?, password = ? where id = ?"
        );
        $this->deleteStmt = $pdo->prepare("delete from users where id = ?");
    }

    /**
     * @param int $id
     *
     * @return UserEntity
     */
    public function findById(int $id): UserEntity
    {
        if (true === $this->identityMap->hasId($id)) {
            return $this->identityMap->getObject($id);
        }

        $this->selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$id]);
        $result = $this->selectStmt->fetch();

        if (!$result) {
            throw new MapperException('User not found');
        }

        $user = new UserEntity(
            $result["username"],
            $result["first_name"],
            $result["last_name"],
            $result["city"],
            $result["created_at"],
            $result["updated_at"],
            $result["password"]
        );
        $user->setId($id);

        $this->identityMap->set($id, $user);

        return $user;
    }

    /**
     * @param string $name
     * @return array
     */
    public function findByFirstName(string $name): array
    {
        $this->selectStmtByName->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectStmtByName->execute(['%'.$name.'%']);
        $result = $this->selectStmtByName->fetchAll();
        if (empty($result)) {
            return [];
        }

        $users= [];
        foreach ($result as $row) {
            $user = new UserEntity(
                $row["username"],
                $row["first_name"],
                $row["last_name"],
                $row["city"],
                $row["created_at"],
                $row["updated_at"],
                $row["password"]
            );
            $user->setId($row["id"]);
            $users[] = $user;
        }

        return $users;
    }

    /**
     * @param UserEntity $user
     * @return int
     */
    public function insert(UserEntity $userEntity): int
    {
        if (true === $this->identityMap->hasObject($userEntity)) {
            throw new MapperException('Object has an ID, cannot insert.');
        }

        $this->insertStmt->execute([
            $userEntity->getUsername(),
            $userEntity->getFirstName(),
            $userEntity->getLastName(),
            $userEntity->getCity(),
            $userEntity->getCreatedAt(),
            $userEntity->getUpdatedAt(),
            $userEntity->getPassword()
        ]);

        $userEntity->setId((int) $this->pdo->lastInsertId());
        $this->identityMap->set($userEntity->getId(), $userEntity);

        return $userEntity->getId();
    }

    /**
     * @param UserEntity $userEntity
     * @return bool
     */
    public function update(UserEntity $userEntity): bool
    {
        if (false === $this->identityMap->hasObject($userEntity)) {
            throw new MapperException('Object has no ID, cannot update.');
        }

        $this->updateStmt->execute([
            $userEntity->getUsername(),
            $userEntity->getFirstName(),
            $userEntity->getLastName(),
            $userEntity->getCity(),
            $userEntity->getCreatedAt(),
            $userEntity->getUpdatedAt(),
            $userEntity->getPassword(),
            $userEntity->getId()
        ]);

        if ($this->updateStmt->rowCount() == 1) {
            return true;
        }

        return false;
    }

    /**
     * @param UserEntity $userEntity
     *
     * @return bool
     */
    public function delete(UserEntity $userEntity): bool
    {
        if (false === $this->identityMap->hasObject($userEntity)) {
            throw new MapperException('Object has no ID, cannot delete.');
        }

        $this->deleteStmt->execute([$userEntity->getId()]);

        if ($this->deleteStmt->rowCount() == 0) {
            return false;
        }

        return true;
    }
}