<?php 

namespace Email\EmailAddons;

use Exception;
use Logs\Logger;

trait EmailMXTrait 
{
    /**
     * Функция проверки MX записей домена 
     * для подтверждения корректности email
     * @return bool
     */
    protected function checkMX(): bool
    {
        $domain = explode('@', $this->email)[1]; 
        $mxHosts = [];

        try {
            if ($info = getmxrr($domain, $mxHosts)) {
                
                if (!empty($mxHosts)) return true;
                else throw new Exception("MX записи не найдены");

            } else {
                throw new Exception("Проверка записи MX не удалась");
            }
        } catch (Exception $e) {
            $log =  "Email {$this->email} Error: {$e->getMessage()}";
            Logger::logToFile($this->logFile, $log);
            return false;
        }
    }
}