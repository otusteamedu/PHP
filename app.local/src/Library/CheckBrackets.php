<?php

namespace Library;


class CheckBrackets
{
    public function isValid(string $input): bool
    {
        $data = trim($input);
        if (empty($data)) {
            return false;
        }
    
        if (strpos($data, ')') === false && strpos($data, '(') === false) {
            return false;
        }
        
        $dataWithoutBrackets = preg_replace('#(\([^()]*\))+#', '', $data);
        $dataWithoutBracketsTrim = trim($dataWithoutBrackets);
        if (empty($dataWithoutBracketsTrim)) {
            return true;
        }
        
        return $this->isValid($dataWithoutBracketsTrim);
    }
}
