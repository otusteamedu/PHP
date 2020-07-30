<?php

namespace Classes\Dto;

/**
 * @property int $id
 * @property string $message
 */

class PushDto
{
    public $id;
    public $message;

    public static function build(PushDtoBuilder $builder)
    {
        $self = new self();
        $self->id = $builder->getId();
        $self->message = $builder->getMessage();

        return $self;
    }
}
