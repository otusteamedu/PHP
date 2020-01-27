<?php

namespace Tirei01\Hw6;

class Application
{
    protected array $arEmails;
    protected array $arErrors;

    public function __construct(?array $arEmails)
    {
        $this->arEmails = $arEmails;
    }

    /**
     * Провека email
     *
     * @param string $email
     *
     * @return bool
     */
    private function checkEmail(string $email): bool
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
            $this->arErrors[$email] = 'Некорректный ' . $email;
            return false;
        }
        return true;
    }

    /**
     * Проветка mx записей
     *
     * @param string $email
     *
     * @return boolean
     */
    private function checkMx(string $email): bool
    {
        $arEmail = explode('@', $email);
        $arMx = array();
        $checkMx = getmxrr($arEmail[1], $arMx);
        if ($checkMx === false || count($arMx) === 0) {
            return false;
        }
        return true;
    }

    /**
     * Проверка email
     * @return void
     */
    public function validateEmails(): void
    {
        foreach ($this->arEmails as $email) {
            if ($this->checkEmail($email)) {
                if ($this->checkMx($email) === false) {
                    $this->arErrors[$email] = 'У ' . $email . ' некорректная MX-запись';
                }
            }
        }
    }

    /**
     * Получить ошибки
     * @return array
     */
    public function getErrors(): array
    {
        return $this->arErrors;
    }

    public function run(): void
    {
        $this->validateEmails();
    }
}