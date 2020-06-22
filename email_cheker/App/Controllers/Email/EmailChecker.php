<?php

namespace Email;

use Contracts\EmailCheckerInterface;
use Logs\Logger;
use Exception;


class EmailChecker implements EmailCheckerInterface
{
    use EmailAddons\EmailMXTrait;
    use EmailAddons\EmailRegExpTrait;

    protected $email;
    protected $logFile = 'email.log';

    public function __construct($email) 
    {   
        $this->email = $email;
    }

    /**
     * Функция объединения проверок email
     * @return bool
     */
    protected function checkBuilds(): bool
    {
        
        if(!$this->checkMX()) return false;
        if(!$this->checkRegExpEmail()) return false;
        return true;
    }
    /**
     * Функция, результирующая проверки
     * @return bool
     */
    public function checkEmail(): bool
    {
        try {
             
            if ($this->checkBuilds()) {
                
                $log = "Email {$this->email} is valid";
                Logger::logToFile($this->logFile, $log);

                return true;
            } else {
                throw new Exception("Email {$this->email} is invalid;");
            }
        } catch(Exception $e) {

            $log =  "Email {$this->email} Error: {$e->getMessage()}";
            Logger::logToFile($this->logFile, $log);

            return false;
        }
    }

    /**
     * Функция проверки email-адресов из файла
     * @return bool
     */
    public function checkEmailsFromFile(): bool
    {

    }

    /**
     * Функция проверки массива email-адресов
     * @return bool
     */
    public function checkEmailsArray(): bool
    {

    }
}