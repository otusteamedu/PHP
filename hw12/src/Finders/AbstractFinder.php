<?php

declare(strict_types=1);

namespace RowDataGateway\Finders;

use PDO;

abstract class AbstractFinder
{
    /**
     * @var PDO
     */
    protected $pdo;

    /**
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
}
