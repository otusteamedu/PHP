<?php

namespace Classes;

class BracketCheckResponseBuilder
{

    private $builderErrors;
    private $bracketCheckErrors;
    private $status;
    private $responseMessage;


    public function setResponseMessage(string $responseMessage): BracketCheckResponseBuilder
    {
        $this->responseMessage = $responseMessage;
        return $this;
    }

    public function setStatus(string $status): BracketCheckResponseBuilder
    {
        $this->status = $status;
        return $this;
    }

    public function setBracketCheckErrors(string $bracketCheckErrors): BracketCheckResponseBuilder
    {
        $this->bracketCheckErrors = $bracketCheckErrors;
        return $this;
    }

    public function build(): BracketCheckResponse
    {
        $this->validate();
        if (!empty($this->builderErrors)) {
            throw new \RuntimeException(implode(';' , $this->builderErrors));
        }
        return BracketCheckResponse::build($this);
    }

    private function validate(): void
    {

        if (!$this->status) {
            $this->builderErrors[] = 'Не передан статус ответа';
        }
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getBracketCheckErrors(): string
    {
        return $this->bracketCheckErrors;
    }

    public function getResponseMessage(): string
    {
        return $this->responseMessage;
    }

}
