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
}