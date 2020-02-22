<?php

namespace App\Mappers;

use App\Database\DataBaseQueriesBuilderInterface;
use App\Entities\UserEntity;
use Exception;

class UserMapper extends AbstractMapper implements DataMapperInterface
{
    /**
     * @var \PDOStatement
     */
    protected $selectStmt;

    /**
     * @var \PDOStatement
     */
    protected $insertStmt;

    /**
     * @var \PDOStatement
     */
    protected $updateStmt;

    /**
     * @var \PDOStatement
     */
    protected $deleteStmt;

    /**
     * @var bool|\PDOStatement
     */
    protected $selectStmtByName;

    protected $tableName = 'users';
    protected $tableFields = ['username', 'first_name', 'last_name', 'city', 'created_at', 'updated_at', 'password'];

    /**
     * UserMapper constructor.
     * @param \PDO $pdo
     * @param DataBaseQueriesBuilderInterface $queries
     * @throws Exception
     */
    public function __construct()
    {
        parent::__construct();

        $this->selectStmt = $this->pdo->prepare($this->queries->findById($this->getTableName()));
        $this->selectStmtByName = $this->pdo->prepare($this->queries->findBy($this->getTableName(), 'first_name'));
        $this->insertStmt = $this->pdo->prepare($this->queries->insert($this->getTableName(), $this->getTableFields()));
        $this->updateStmt = $this->pdo->prepare($this->queries->update($this->getTableName(), $this->getTableFields()));
        $this->deleteStmt = $this->pdo->prepare($this->queries->delete($this->getTableName()));
    }

    /**
     * @param int $id
     *
     * @return object
     * @throws Exception
     */
    public function findById($id): object
    {
        if (true === $this->identityMap->hasId($id)) {
            return $this->identityMap->getObject($id);
        }

        $this->selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$id]);
        $result = $this->selectStmt->fetch();

        if (!$result) {
            throw new Exception('User not found');
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
     * @param UserEntity $userEntity
     * @return int
     * @throws Exception
     */
    public function insert($userEntity): int
    {
        if (true === $this->identityMap->hasObject($userEntity)) {
            throw new Exception('Object has an ID, cannot insert.');
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
     * @param $userEntity
     * @return bool
     * @throws Exception
     */
    public function update($userEntity): bool
    {
        if (false === $this->identityMap->hasObject($userEntity)) {
            throw new Exception('Object has no ID, cannot update.');
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
     * @throws Exception
     */
    public function delete($userEntity): bool
    {
        if (false === $this->identityMap->hasObject($userEntity)) {
            throw new \Exception('Object has no ID, cannot delete.');
        }

        $this->deleteStmt->execute([$userEntity->getId()]);

        if ($this->deleteStmt->rowCount() == 0) {
            return false;
        }

        return true;
    }

    /**
     * @return string
     */
    protected function getTableName(): string
    {
        return $this->tableName;
    }

    /**
     * @return array
     */
    protected function getTableFields(): array
    {
        return $this->tableFields;
    }
}