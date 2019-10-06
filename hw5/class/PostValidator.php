<?php

class PostValidator
{
    private $error = false;

    public function run()
    {
       $this->string_validate($_POST['string']);
    }

    public function string_validate($string=''){
        if (empty(trim($string))) {
            $this->error = true;
        } else {
            $this->error = $this->correctBracket($string);
        }
    }

    public function correctBracket($string)
    {
        if (!empty($string)) {
            $rep_string = preg_replace('/[\(]{1}[\)]{1}/', '', $string, $limit = -1, $count);
            if ($count > 0) {
                return $this->correctBracket($rep_string);
            } else {
                return true;
            }
        }
        return false;
    }

    public function getError()
    {
        return $this->error;
    }
}