<?php

namespace Src\Database\Connectors;

abstract class BaseSqlConnector extends Connector
{
    protected ?string $dbname;
    protected ?string $user;
    protected ?string $pass;

    public function __construct(
        protected string $dsn,
        protected array $config,
    )
    {
        parent::__construct();
        $this->dbname   = $this->config['dbname'] ?? null;
        $this->user     = $this->config['user'] ?? null;
        $this->pass     = $this->config['pass'] ?? null;
    }

}