<?php

declare(strict_types=1);

namespace App;

use App\Console\Console;
use App\Validator\Validator;
use Exception;

class App
{

    public function run(): void
    {
        try {
            $emails = $this->getEmails();
            $this->exitIfNoEmailListIsSpecified($emails);

            Console::success('Старт валидации');

            $rules = $this->getRules();

            $this->validationEmails($emails, $rules);

            Console::success('Валидация завершена');
        } catch (Exception $e) {
            Console::error('Error: ' . $e->getMessage());
        }
    }

    private function getEmails(): array
    {
        $emails = Console::readLines();

        return array_filter($emails);
    }

    private function getRules(): array
    {
        return [
            'email',
            'email-domain',
        ];
    }

    private function validationEmails(array $emails, array $rules): void
    {
        foreach ($emails as $email) {
            if (!Validator::validate($email, $rules)) {
                Console::error($email . ' ... ' . Validator::getErrorMessage());
            } else {
                Console::success($email . ' ... ok');
            }
        }
    }

    private function exitIfNoEmailListIsSpecified(array $emails): void
    {
        if (!$emails) {
            Console::error('Не указан список адресов электронной почты');
            exit;
        }

    }

}
