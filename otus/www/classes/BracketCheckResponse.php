<?php

namespace Classes;

class BracketCheckResponse
{
    public $status;
    public $bracketCheckErrors;
    public $responseMessage;

    public static function build(BracketCheckResponseBuilder $builder): BracketCheckResponse
    {
        $self = new self();
        $self->status = $builder->getStatus();
        $self->bracketCheckErrors = $builder->getBracketCheckErrors();
        $self->responseMessage = $builder->getResponseMessage();

        return $self;
    }
}
