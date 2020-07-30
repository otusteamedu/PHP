<?php

namespace Classes\Dto;

/**
 * @property string $broker
 * @property string $host
 * @property int $port
 * @property string $userName
 * @property string $password
 * @property string $queueRequestName
 * @property string $queueResponseName
 */

class BrokerDto
{
    public $broker;
    public $host;
    public $port;
    public $userName;
    public $password;
    public $queueRequestName;
    public $queueResponseName;

    public static function build(BrokerDtoBuilder $builder)
    {
        $self = new self();
        $self->broker = $builder->getHost();
        $self->host = $builder->getHost();
        $self->port = $builder->getPort();
        $self->userName = $builder->getUserName();
        $self->password = $builder->getPassword();
        $self->queueRequestName = $builder->getQueueRequestName();
        $self->queueResponseName = $builder->getQueueResponseName();

        return $self;
    }
}
