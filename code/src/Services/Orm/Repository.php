<?php


namespace App\Services\Orm;


use App\Services\Orm\Exceptions\OrmModelNotFoundException;
use App\Services\Orm\Mapping\AirlineMapper;
use App\Services\Orm\Mapping\AirplaneMapper;
use App\Services\Orm\Interfaces\MapperInterface;
use PDO;


class Repository
{
    private MapperInterface $mapper;
    private IdentityMap $identityMap;
    private string $modelClassName;
    private PDO $pdo;

    /**
     * Repository constructor.
     * @param string $modelClassName
     * @param PDO $pdo
     * @param ModelManager $mm
     */
    public function __construct(string $modelClassName, PDO $pdo, ModelManager $mm)
    {
        $this->modelClassName = $modelClassName;
        $this->pdo = $pdo;

        $this->identityMap = IdentityMap::getInstance();
        $name = $this->getShortName($modelClassName);

        switch ($name) {
            case 'Airline':
                $this->mapper = new AirlineMapper($pdo, $mm);
                break;

            case 'Airplane':
                $this->mapper = new AirplaneMapper($pdo);
                break;

            default:
                throw new OrmModelNotFoundException('Model not found');
        }
    }

    public function getMapper(): MapperInterface
    {
        return $this->mapper;
    }

    public function findOne(int $id)
    {
        if ($model = $this->identityMap->get($this->modelClassName, $id)) {
            return $model;
        }

        $model = $this->mapper->findById($id);
        $this->identityMap->set($model);
        return $model;
    }

    public function find(array $condition = null): array
    {
        $builder = $this->mapper->getBuilder();

        $where = null;
        if ($condition) {
            $where = ' WHERE ';
            foreach ($condition as $key => $val) {
                $where .= "${key} = '${val}' AND ";
            }
            $where = substr($where, 0, strrpos($where, ' AND '));
        }

        $query = 'SELECT * FROM ' . $this->mapper::TABLE_NAME . $where;
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        $models = [];

        foreach ($rows as $raw) {
            $model = $builder->build($raw);
            $this->identityMap->set($model);
            array_push($models, $model);
        }

        return $models;
    }

    public function findAll(): array
    {
        return $this->find();
    }

    private function getShortName(string $className): string
    {
        $arr = explode('\\', $className);
        return array_pop($arr);
    }


}
