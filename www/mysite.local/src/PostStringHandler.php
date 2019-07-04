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
        if (substr($this->postString, 0, 1) == ')' || substr($this->postString, -1, 1) == '(') {
            $this->errorMsg = 'String cannot begin with ")" and closing with "("!';
        } else {
            $cntLeft = substr_count($this->postString, '(');
            $cntRight = substr_count($this->postString, ')');
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
