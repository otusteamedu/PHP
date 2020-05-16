<?php

namespace Classes\Email;

class EmailCheckResponseBuilder
{
    private $builderErrors;
    private $emailsCheckErrors;
    private $status;
    private $responseMessage;

    public function setResponseMessage(string $responseMessage): EmailCheckResponseBuilder
    {
        $this->responseMessage = $responseMessage;
        return $this;
    }

    public function setStatus(bool $status): EmailCheckResponseBuilder
    {
        $this->status = $status;
        return $this;
    }

    public function setEmailsCheckErrors(array $emailsCheckErrors): EmailCheckResponseBuilder
    {
        $this->emailsCheckErrors = $emailsCheckErrors;
        return $this;
    }

    public function build(): EmailCheckResponse
    {
        $this->validate();
        if (!empty($this->builderErrors)) {
            throw new \RuntimeException(implode(';' , $this->builderErrors));
        }
        return EmailCheckResponse::build($this);
    }

    private function validate(): void
    {

        if (!is_bool($this->status)) {
            $this->builderErrors[] = 'Не передан статус ответа';
        }
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getEmailsCheckErrors(): array
    {
        return $this->emailsCheckErrors;
    }

    public function getResponseMessage(): string
    {
        return $this->responseMessage;
    }
}
