<?php

class PostStringHandler
{
    public $postString = '';
    public $errorMsg = '';
    public $cntParentheses = 0;
    
    public function __construct($postString = '')
    {
        $this->postString = trim($postString);
    }
    
    public function showResult()
    {
        if ($this->check()) {
            $this->showSuccess();
        } else {
            $this->showError();
        }
    }
    
    public function check()
    {
        if (strlen($this->postString) > 0) {
            return $this->checkParentheses();
        }
        
        $this->errorMsg = 'Field "string" undefined!';
        
        return false;
    }
    
    public function checkParentheses()
    {
        preg_match_all('/(\()?(\))?/', $this->postString, $matches);
        $cntLeft = count(array_diff($matches['1'], array('')));
        $cntRight = count(array_diff($matches['2'], array('')));
        if ($cntRight <= 0 && $cntRight <= 0) {
            $this->errorMsg = 'String does not contain parentheses!';
        } else if ($cntLeft > $cntRight) {
            $this->errorMsg = 'Opening parentheses more than closing!';
        } else if($cntLeft < $cntRight) {
            $this->errorMsg = 'Closing parentheses more than opening!';
        } else {
            $this->cntParentheses = $cntRight;
            return true;
        }
        return false;
    }
    
    public function showError()
    {
        header("HTTP/1.0 400 Bad Request");
        echo $this->errorMsg;
    }
    
    public function showSuccess()
    {
        header("HTTP/1.0 200 OK");
        echo "Correct string! String contain {$this->cntParentheses} оpening and closing parentheses.";
    }
    
}