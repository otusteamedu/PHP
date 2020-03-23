<?php

namespace App;

use App\Util\Logger\BaseLogger;
use App\Validation\Usage\EmailValidation;
use \App\Exceptions\ValidationErrorException;

class App
{
    /** @var array $emails */
    protected $emails = [];

    /** @var BaseLogger $logger */
    protected $logger;

    public function __construct()
    {
        $this->logger = new BaseLogger();
    }

    public function setEmails(array $emails)
    {
        $this->emails = $emails;
        return $this;
    }

    public function run()
    {
        $this->validateEmails();
    }

    public function validateEmails()
    {
        $usage = new EmailValidation();

        foreach ($this->emails as $email) {
            $this->logger->info(sprintf('Проверяем: "%s"', $email));
            try {
                $usage->exec($email);
                $this->logger->info('Корректно');
            } catch (ValidationErrorException $ex) {
                $this->logger->error(sprintf('Ошибка при валидации: %s', $ex->getMessage()));
            } catch (\Throwable $t) {
                $this->logger->exception($t);
            }

            $this->logger->newLine();
        }
    }
}