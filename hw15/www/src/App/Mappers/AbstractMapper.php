<?php

namespace App\Mappers;

use App\Config\Config;
use App\Framework\IdentityMap;
use App\Framework\IdentityMapInterface;
use App\Kernel\App;

abstract class AbstractMapper
{
    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * @var IdentityMapInterface
     */
    protected $identityMap;

    /**
     * @var object
     */
    protected $queries;

    protected $tableName = '';
    protected $tableFields = [];

    public function __construct()
    {
        $this->pdo = App::getInstance('pdo');
        $this->queries = Config::createQueriesBuilder();
        $this->identityMap = new IdentityMap();
    }

    public function __destruct()
    {
        unset($this->identityMap, $this->db);
    }

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return $this->tableName;
    }

    /**
     * @param string $tableName
     */
    public function setTableName(string $tableName): void
    {
        $this->tableName = $tableName;
    }

    /**
     * @return array
     */
    public function getTableFields(): array
    {
        return $this->tableFields;
    }

    /**
     * @param array $tableFields
     */
    public function setTableFields(array $tableFields): void
    {
        $this->tableFields = $tableFields;
    }
}