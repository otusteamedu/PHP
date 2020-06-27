<?php

namespace Email\EmailAddons;

use Exception;
use Logs\Logger;

trait EmailRegExpTrait
{
    /**
     * Функция проверки email на синтаксис
     * @return bool
     */
    protected function checkRegExpEmail(): bool
    {
        $regExp = '/^((([0-9A-Za-z]{1}[-0-9A-z\.]{1,}[0-9A-Za-z]{1})|([0-9А-Яа-я]{1}[-0-9А-я\.]{1,}[0-9А-Яа-я]{1}))@([-A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$/u';
        try{
            // if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {

           
            if (!preg_match($regExp, $this->email)) {
                
                throw new Exception("Синтаксис email некорреткный");
                return false;
            }

            
        } catch(Exception $e) {
            $log = "Email {$this->email} Error: {$e->getMessage()}";
            Logger::logToFile($this->logFile, $log);
            return false;
        }
        return true;
    }
}