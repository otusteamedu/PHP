<?php

namespace Classes\Dto;

/**
 * @property string $dbConnection
 * @property string $host
 * @property int $port
 * @property string $dbName
 * @property string $dbUserName
 * @property string $dbPassword
 */

class DbConfigDto
{
    public $dbConnection;
    public $host;
    public $port;
    public $dbName;
    public $dbUserName;
    public $dbPassword;

    public static function build(DbDtoBuilder $builder)
    {
        $self = new self();
        $self->dbConnection = $builder->getDbConnection();
        $self->host = $builder->getHost();
        $self->port = $builder->getPort();
        $self->dbName = $builder->getDbName();
        $self->dbUserName = $builder->getDbUserName();
        $self->dbPassword = $builder->getDbPassword();

        return $self;
    }
}
