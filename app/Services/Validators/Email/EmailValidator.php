<?php


namespace app\Services\Validators\Email;


use app\Services\Validators\AbstractValidator;
use app\Exceptions\Email\BadEmailException;


class EmailValidator extends AbstractValidator
{
    public const VALIDATOR_NAME = 'EmailValidator';
    public const ITEM_NAME      = 'Email';

    /**
     * Список Email-ов
     * @var array
     */
    private array $emails = [];


    /**
     * Устанавливает данные валидации
     *
     * @param array $data
     */
    public function setDataToValidate(array $data): void
    {
        $this->emails = $data;
    }

    /**
     * Возвращает структурированный список Email-ов (разбитый на составляющие: имя, домен, зона)
     * Используется в качестве иллюстрации разбивки email-в.
     * Не участвует в валидации.
     *
     * @return array
     */
    public function getFormatEmailList(): array
    {
        $list = [];
        foreach ($this->emails as $email) {
            $list += $this->getFormattedEmail($email);
        }
        return $list;
    }


    /**
     * Возвращает true если проверяемый элемент валидный
     *
     * @param string $item
     * @return bool
     */
    protected function isValidItem(string $item): bool
    {
        try {
            return $this->isValidEmail($item);
        } catch (BadEmailException $ex) {
            return false;
        }
    }

    /**
     * Возвращает список элементов для проверки
     *
     * @return array
     */
    protected function getItemsList(): array
    {
        return $this->emails;
    }

    /**
     * Возвращает структурированный email
     * ["name"=>имя email-а, "domain"=>домен, "zone"=>зона];
     *
     * @param $email
     * @return array
     */
    public function getFormattedEmail($email): array
    {
        $result = [];
        $parse = explode("@", $email);
        $name = $parse[0];
        $domain = preg_replace("/(.[^.]+)$/", "", $parse[1]);
        preg_match('/([^.]+)$/', $parse[1], $matches);
        $zone = $matches[0];
        $result[$email] = ["name"=>$name, "domain"=>$domain, "zone"=>$zone];
        return $result;
    }

    /**
     * Возвращает true если email валидный
     *
     * @param string $email
     * @return bool
     * @throws BadEmailException
     */
    public function isValidEmail(string $email): bool
    {
        return ($this->checkValid($email)
            && $this->checkMX($this->getDomain($email)));
    }

    /**
     * Проверяет на правильность синтаксиса почтового ящика
     * возвращает true если формат email соответствует стандарту
     *
     * @param string $email
     * @return bool
     * @throws BadEmailException
     */
    private function checkValid(string $email):bool
    {
        if (!preg_match('/^((([0-9A-Za-z][-0-9A-z\.]+[0-9A-Za-z])|([0-9А-Яа-я]{1}[-0-9А-я\.]+[0-9А-Яа-я]))@([-A-Za-z]+\.){1,2}[-A-Za-z]{2,})$/u', $email)) {
            throw new BadEmailException("У адреса $email Не верный формат");
        } else return true;
    }

    /**
     * Возвращает домен из почтового ящика
     *
     * @param string $email
     * @return string
     */
    private function getDomain(string $email):string
    {
        return substr(strrchr($email, "@"), 1);
    }

    /**
     * Возвращает true если для домена существует MX запись
     *
     * @param $domain
     * @return bool
     * @throws BadEmailException
     */
    private function checkMX($domain):bool
    {
        $result = getmxrr($domain, $mx_records, $mx_weight);
        if ((false == $result
            || 0 == count($mx_records)
            || (1 == count($mx_records)
                && ($mx_records[0] == null
                    || $mx_records[0] == "0.0.0.0")))) {
            throw new BadEmailException("Отсутствует почтовый домен");
        } else return true;
    }

}