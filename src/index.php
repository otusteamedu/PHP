<?php
    $postStr = $_POST['string'];
    if (checkBrackets($postStr)) {
        http_response_code(200);
        echo 'Tasty brackets, thx';
    } else {
        http_response_code(400);
        echo 'Error in brackets occurred';
    }

    exit();

    function checkBrackets($string) {
        if (!empty($string)) {
            $chars = str_split($string);
            $bracketCounter = 0;
            foreach ($chars as $char) {
                if ($bracketCounter < 0) {

                    return false;
                }
                switch ($char) {
                    case ')':
                        $bracketCounter--; break;
                    case '(':
                        $bracketCounter++; break;
                }
            }
            if ($bracketCounter === 0) {

                return true;
            }
        }

        return false;
    }
