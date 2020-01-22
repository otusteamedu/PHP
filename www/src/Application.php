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
            $this->arErrors[$email] = 'У ' . $email . ' некорректная MX-запись';
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
                $this->checkMx($email);
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
        $arErrors = $this->getErrors();
        if (count($arErrors) > 0) {
            foreach ($arErrors as $error) {
                echo $error . PHP_EOL;
            }
        }

        // TODO DEL THIS
        echo "<pre style='color:red; clear: both;'>";
        print_r($this->getIp());
        echo "</pre>";
    }

    /**
     * @return string|null
     */
    protected function getIp() : ?string
    {
        return $_SERVER['SERVER_ADDR'];
    }

}