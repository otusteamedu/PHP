<?php

namespace Classes\Email;

class EmailCheckResponse
{
    public $status;
    public $emailsCheckErrors;
    public $responseMessage;

    public static function build(EmailCheckResponseBuilder $builder): EmailCheckResponse
    {
        $self = new self();
        $self->status = $builder->getStatus();
        $self->emailsCheckErrors = $builder->getEmailsCheckErrors();
        $self->responseMessage = $builder->getResponseMessage();

        return $self;
    }
}
