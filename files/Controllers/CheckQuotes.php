<?php

namespace Brackets\Controllers;

use Brackets\Controllers\HttpResponses;
use Exception;

class CheckQuotes extends HttpResponses
{
    private $strToCheck;
    private $code;

    public function __construct($str) 
    {
        $this->strToCheck = $str;
    }

    /**
     * Функция проверки строки на пустоту
     * @return bool
     */
    public function preCheck(): bool
    {
        try {
            if (empty($this->strToCheck) || strlen($this->strToCheck) > 48 ) {
                throw new Exception('400');
            } else {
                return true;
            }
        } catch (Exception $e) {
            $this->$code = $e->getMessage();
            http_response_code($this->$code);
            echo $this->$code . $this->getHttpResponseText($this->$code);
            return false;
        }      
    }

    /**
     * Функция подсчета скобок
     * @return int
     */
    protected function countBrackets(): int
    {
        $counter = 0;
        for ($i = 0; $i < strlen($this->strToCheck); $i++) {
            if ($this->strToCheck[$i] == '(') $counter++;
            else if ($this->strToCheck[$i] == ')') $counter--;

            if ($counter < 0) {
                throw new Exception('400') ;
                break;
            }
        }
        return $counter;
    }

    /**
     * Функция проверки на кол-во скобок
     */
    public function checkStringQuotes() 
    {
        
        if ($this->preCheck()) {
            
            try {
                $counter = $this->countBrackets();
                
                if ($counter === 0) {
                    http_response_code(200);
                    echo '200 ' . $this->getHttpResponseText(200);
                    return;
                } else {
                    throw new Exception('400') ;
                }
            } catch (Exception $e) {
                $this->$code = $e->getMessage();
                http_response_code($this->$code);
                echo $this->$code . $this->getHttpResponseText($this->$code);
                return false;
            }
        }
    }
}

