<?php

namespace Nlazarev\Hw6\Model\Email;

use Nlazarev\Hw6\Model\Email\EmailString;

class EmailStrings
{
    private $email_strings = array();

    public function __construct(array $email_strings = array())
    {
        $this->email_strings = $email_strings;
    }

    public function getEmailStrings(): array
    {
        return $this->email_strings;
    }

    public function setEmailStringsFromFile(string $email_strings_file): bool
    {
        $this->email_strings = array();
        $handle = @fopen($email_strings_file, "r");

        if ($handle) {
            while (($buffer = fgets($handle, 4096)) !== false) {
                $this->email_strings[] = new EmailString(str_replace(array("\r", "\n"), "", $buffer));
            }
    
            if (!feof($handle)) { //TODO: обработка незавершенного считывания из файла
                $this->email_strings = array();  
                return false;
            }
    
            fclose($handle);
            return true;
        } else {
            return false;
        }
    }    

}