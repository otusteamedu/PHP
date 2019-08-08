<?php

declare(strict_types=1);

namespace Otus\hw22\Mapper\PDO;

use Otus\hw22\Mapper\MapperInterface;

abstract class AbstractMapper implements MapperInterface
{
    /**
     * @var array
     */
    protected $relations = [];

    /**
     * @var \PDO
     */
    protected $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;

        $this->init();
    }

    public function init(): void
    {

    }
}