<?php


namespace App\Services\Orm;


use App\Services\Orm\Interfaces\OrmModelInterface;
use App\Utils\Config;
use PDO;
use Psr\Container\ContainerInterface;


class ModelManager
{
    private PDO $pdo;
    private IdentityMap $identityMap;
    private array $repositories;

    /**
     * ModelManager constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->pdo = $container->get(PDO::class);
        $this->identityMap = IdentityMap::getInstance();
    }

    public function getRepository(string $className): Repository
    {
        $key = $this->getRepositoryKey($className);
        if (!isset($this->repositories[$key])) {
            $this->repositories[$key] = new Repository($className, $this->pdo, $this);
        }

        return $this->repositories[$key];
    }

    public function save(OrmModelInterface &$model): void
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

    public function delete(OrmModelInterface $model): bool
    {
        $repo = $this->getRepository(get_class($model));
        $isDeleted = $repo->getMapper()->delete($model);
        if ($isDeleted) {
            $this->identityMap->delete($model);
        }

        return $isDeleted;
    }


    private function getRepositoryKey(string $modelClassName): string
    {
        return $modelClassName . ':repository';
    }
}
