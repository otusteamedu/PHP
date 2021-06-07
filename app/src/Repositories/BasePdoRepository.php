<?php


namespace App\Repositories;

use App\Entities\Entity;
use App\Services\Database\DB;
use App\Services\ServiceContainer\AppServiceContainer;
use Illuminate\Support\Collection;
use PDO;
use PDOStatement;

abstract class BasePdoRepository
{
    /**
     * @var PDO
     */
    protected PDO $pdo;

    protected string $table = '';

    public function __construct()
    {
        $db = AppServiceContainer::getInstance()->resolve(DB::class);
        $this->pdo = $db->getPdo();
        $this->pdo->setAttribute( PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC );
        $this->pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
    }

    public function getAll(array $columns = ['*']) : Collection
    {
        $query = $this->pdo->prepare(
            'SELECT ' . implode(',', $columns) . ' FROM ' . $this->table
        );

        $this->executeQuery($query);

        $results = $query->fetchAll();
        $collection = collect();

        foreach($results as $row){
            $collection->push($this->mapEntity($row));
        }

        return $collection;
    }

    public function getById(int $id, array $columns = ['*']) : Entity
    {
        $query = $this->pdo->prepare(
            'SELECT ' . implode(',', $columns) . ' FROM ' . $this->table . ' WHERE id = ?'
        );

        $this->executeQuery($query, [$id]);

        return $this->mapEntity($query->fetch());
    }

    public function insert(array $entityData) : Entity
    {
        $query = $this->pdo->prepare(
            'INSERT INTO ' .  $this->table  . '('. implode(',', array_keys($entityData)) . ')' . ' VALUES '
            . '(' . implode(',', array_fill(0, count($entityData),'?')) . ');'
        );

        $this->executeQuery($query, array_values($entityData));

        $entityData['id'] = $this->pdo->lastInsertId();

        return $this->mapEntity($entityData);
    }

    public function update(Entity $entity) : bool
    {
        $entityData = $entity->toArray();
        $values = array_reduce(array_keys($entityData), static function($carry, $item){
            $carry .= $item . ' = ?,';
            return $carry;
        }, '');

        $query = $this->pdo->prepare(
            'UPDATE ' .  $this->table  . ' SET ' . trim($values, ',') . 'WHERE id = ?'
        );

        $entityData[] = $entity->getId();

        return $this->executeQuery($query, array_values($entityData));
    }

    public function delete(Entity $entity)
    {
        $query = $this->pdo->prepare(
            'DELETE FROM ' .  $this->table  . ' WHERE id = ?'
        );

        return $this->executeQuery($query, [$entity->getId()]);
    }

    private function executeQuery(PDOStatement $statement, array $params = []) : bool
    {
        $result = $statement->execute($params);

        if($result) {
            return true;
        }

       [$sqlState, $errorCode, $errorMessage] =  $this->pdo->errorInfo();

        if($sqlState == 0){
            $errorMessage = 'Invalid query ' . $statement->queryString . ' with params: ' . implode(',' , $params);
        }

        throw new \RuntimeException($errorMessage, 500);
    }

    abstract protected function mapEntity(array $entityData) : Entity;
}