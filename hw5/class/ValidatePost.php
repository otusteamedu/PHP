<?php

class ValidatePost
{
    private $error = false;

    public function run()
    {
        if (empty(trim($_POST['string']))) {
            $this->error = true;
        } else {
            $new_string = preg_replace('/[^\(\)]/', '', $_POST['string']);
            if (!empty($new_string)) {
                $this->error = $this->correctBracket($_POST['string']);
            }
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