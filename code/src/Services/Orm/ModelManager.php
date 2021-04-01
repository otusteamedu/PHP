<?php


namespace App\Services\Orm;


use App\Services\Orm\Interfaces\ModelInterface;
use App\Utils\Config;
use App\Utils\DatabaseConnectionInterface;
use PDO;
use Psr\Container\ContainerInterface;


class ModelManager
{
    private PDO $pdo;
    private IdentityMap $identityMap;
    private array $repositories;

    /**
     * ModelManager constructor.
     * @param DatabaseConnectionInterface $connection
     */
    public function __construct(DatabaseConnectionInterface $connection)
    {
        $this->pdo = $this->createPDO($connection->getDsn());
        $this->identityMap = IdentityMap::getInstance();
    }

    public function getRepository(string $className): Repository
    {
        $key = $this->getRepositoryKey($className);
        if (!isset($this->repositories[$key])) {
            $this->repositories[$key] = new Repository($className, $this);
        }

        return $this->repositories[$key];
    }

    public function save(ModelInterface &$model): void
    {
        $repo = $this->getRepository(get_class($model));
        $id = $model->getId();

        if ($id && $repo->findOne($model->getId())) {
            $repo->getMapper()->update($model);
        } else {
            $model = $repo->getMapper()->insert($model->toArray());
        }

        $this->identityMap->set($model);
    }

    public function delete(ModelInterface $model): bool
    {
        $repo = $this->getRepository(get_class($model));
        $isDeleted = $repo->getMapper()->delete($model);
        if ($isDeleted) {
            $this->identityMap->delete($model);
        }

        return $isDeleted;
    }

    public function getPDO(): PDO
    {
        return $this->pdo;
    }

    private function getRepositoryKey(string $modelClassName): string
    {
        return $modelClassName . ':repository';
    }

    private function createPDO(string $dsn): PDO
    {
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        return new PDO($dsn, null, null, $options);
    }
}
