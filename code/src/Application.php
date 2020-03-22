<?php
namespace code\src;
class Application {
    private  $validator;
    private  $parameter;

    public function __construct() {
        $this->parameter = $_POST['string'];
        $this->validator = new Validator($this->parameter);
    }

    public function setMessage ($message) :string {
        if (!isset($this->parameter)) {$message = 'Everything is VERY BAD';return $message;}
        if (empty($this->parameter)) {$message = 'Everything is VERY BAD';return $message;}
        if ($this->validator->validate()) {$message = 'Everything is GOOD';}
        if (!$this->validator->validate())  {$message = 'Everything is BAD';}
        return $message;
    }
    public function run () {
        echo $this->setMessage($this);
    }
}