<?php

namespace Classes\Email;

use Classes\Email\Validator\EmailValidatorsService;

class EmailCheckServiceImpl implements EmailCheckService
{
    private $emailValidatorService;
    private $emails;

    public function __construct(EmailValidatorsService $emailValidatorsService, array $emails)
    {
        $this->emailValidatorService = $emailValidatorsService;
        $this->emails = $emails;
    }

    public function run(): EmailCheckResponse
    {
        foreach ($this->emails as $email) {
            $this->emailValidatorService->isValid($email);
        }

        $emailCheckResponseBuilder = new EmailCheckResponseBuilder();

        if (!empty($this->emailValidatorService->getErrors())) {
            return $emailCheckResponseBuilder
                ->setStatus(false)
                ->setResponseMessage('Проверка email не пройдена')
                ->setEmailsCheckErrors($this->emailValidatorService->getErrors())
                ->build();
        }
        return $emailCheckResponseBuilder
            ->setStatus(true)
            ->setResponseMessage('Проверка email пройдена успешно')
            ->setEmailsCheckErrors([])
            ->build();
    }
}
