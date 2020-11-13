<?php declare(strict_types=1);


namespace Email;


/**
 * Class EmailChecker
 * Класс проверки Email адресов
 * @package Email
 */
class EmailChecker
{
    private string $email;
    private array $errors;


    /**
     * Функция проверки Email
     * @param string $email
     * @return bool
     */
    public function check(string $email): bool
    {
        $this->email = $email;
        return $this->validation() && $this->checkDnsMx();
    }


    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }


    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }


    private function addError(string $error): void
    {
        $this->errors[] = $error;
    }


    private function checkDnsMx(): bool
    {
        $domain = $this->getDomain();

        if (checkdnsrr($domain)) {
            return true;
        } else {
            $this->addError("MX запись домена {$domain} не найдена");
            return false;
        }
    }


    private function getDomain(): string
    {
        return substr(strrchr($this->email, "@"), 1);
    }


    private function validation(): bool
    {
        $regExp = "/^[a-z0-9][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i";
        if(preg_match($regExp, $this->email)){
            return true;
        } else {
            $this->addError("Введен не корректный Email");
            return false;
        }
    }
}
