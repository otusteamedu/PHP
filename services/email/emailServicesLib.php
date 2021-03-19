<?php


namespace Services\Email;


class emailServicesLib
{
    private array $reason = [];

    /**
     * emailServicesLib constructor.
     * @param array $emails
     */
    public function __construct(private array $emails)
    {
    }

    /**
     * Возвращает структурированных список Email-ов
     * @return array
     */
    public function getFormattedEmailList():array
    {
        $list = [];
        foreach ($this->emails as $email) {
            $list += $this->getFormattedEmail($email);
        }
        return $list;
    }

    /**
     * Возвращает структурированный email
     * ["name"=>имя емейла, "domain"=>домен, "zone"=>зона];
     * @param $email
     * @return array
     */
    public function getFormattedEmail($email):array
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
     * @param string $email
     * @return bool
     * @throws \Exception
     */
    public function isValidEmail(string $email):bool
    {
        return ($this->checkValid($email)
                && $this->checkMX($this->getDomain($email)));
    }

    /**
     * Проверяет на правильность синтаксиса почтового ящика
     * возвращает true если формат email соответствует стандарту
     * @param string $email
     * @return bool
     * @throws \Exception
     */
    private function checkValid(string $email):bool
    {
        if (!preg_match('/^((([0-9A-Za-z]{1}[-0-9A-z\.]{1,}[0-9A-Za-z]{1})|([0-9А-Яа-я]{1}[-0-9А-я\.]{1,}[0-9А-Яа-я]{1}))@([-A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$/u', $email)) {
            throw new \Exception("Не верный формат электронного адреса");
        } else return true;
    }

    /**
     * Возвращает домен из почтового ящика
     * @param string $email
     * @return string
     */
    private function getDomain(string $email):string
    {
        return substr(strrchr($email, "@"), 1);
    }

    /**
     * Возвращает true если для домена существует MX запись
     * @param $domain
     * @return bool
     * @throws \Exception
     */
    private function checkMX($domain):bool
    {
        $result = getmxrr($domain, $mx_records, $mx_weight);
        if ((false == $result
                || 0 == count($mx_records)
                || (1 == count($mx_records)
                    && ($mx_records[0] == null
                    || $mx_records[0] == "0.0.0.0")))) {
            throw new \Exception("Отсутствует почтовый домен");
        } else return true;
    }
}