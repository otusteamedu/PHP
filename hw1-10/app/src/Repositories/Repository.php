<?php
namespace Src\Repositories;

/**
 * Class Repository
 *
 * @package Src\Repositories
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