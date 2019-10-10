<?php

namespace TimGa\hw26\validator;

class AbstractValidator
{

    protected $error='';

    protected function setError(string $error): void
    {
        $this->error = $error;
    }
    
    public function getError(): string
    {
        return $this->error;
    }

}
