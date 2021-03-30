<?php


namespace App\Services\Orm;


use App\Services\Orm\Exceptions\OrmModelNotFoundException;
use App\Services\Orm\Mappers\AirlineMapper;
use App\Services\Orm\Mappers\AirplaneMapper;
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
     */
    public function __construct(string $modelClassName, PDO $pdo)
    {
        $this->modelClassName = $modelClassName;
        $this->pdo = $pdo;

        $this->identityMap = IdentityMap::getInstance();
        $name = $this->getShortName($modelClassName);

        switch ($name) {
            case 'Airline':
                $this->mapper = new AirlineMapper($pdo);
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

    public function findAll(): array
    {
        $builder = $this->mapper->getBuilder();

        $query = 'SELECT * FROM ' . $this->mapper::TABLE_NAME;
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $data = $stmt->fetchAll();

        $models = [];

        foreach ($data as $raw) {
            $model = $builder->build($raw);
            $this->identityMap->set($model);
            array_push($models, $model);
        }

        return $models;
    }

    private function getShortName(string $className): string
    {
        $arr = explode('\\', $className);
        return array_pop($arr);
    }


}
