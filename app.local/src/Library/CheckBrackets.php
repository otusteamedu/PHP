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
        
        $pattern = '#(\([^()]*\))+#';
        if (preg_match($pattern, $data)) {
            $dataWithoutBrackets     = preg_replace('#(\([^()]*\))+#', '', $data);
            $dataWithoutBracketsTrim = trim($dataWithoutBrackets);
            if (empty($dataWithoutBracketsTrim)) {
                return true;
            }
    
            return $this->isValid($dataWithoutBracketsTrim);
        }
        
        return false;
    }
}
