<?php

namespace Classes;

class BracketCheckRequest
{
    private $string;

    public static function build(BracketCheckRequestBuilder $bracketCheckRequestBuilder): BracketCheckRequest
    {
        $self = new self();
        $self->string = $bracketCheckRequestBuilder->getString();

        return $self;
    }

    public function getString(): string
    {
        return $this->string;
    }

}
