<?php
namespace Src\Repositories;

/**
 * Class Repository initializes needed database
 */
class Repository
{
    /**
     * @var $repository
     */
    private $repository;

    public function __construct ()
    {
       $this->setRepository($_ENV['DB_NAME']);
    }

    /**
     * @param string $repositoryName
     */
    public function setRepository (string $repositoryName): void
    {
        if ($repositoryName === RedisRepository::RedisDbName) {
            $this->repository = new RedisRepository();
        }
    }

    /**
     * @return mixed
     */
    public function getRepository ()
    {
        return $this->repository;
    }
}